<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Actions;

use Illuminate\Support\Facades\DB;
use Rimba\Knowledge\Enums\AttemptStatus;
use Rimba\Knowledge\Enums\LearningStatus;
use Rimba\Knowledge\Enums\QuestionBankStatus;
use Rimba\Knowledge\Models\QualificationAnswer;
use Rimba\Knowledge\Models\QualificationAttempt;
use Rimba\Knowledge\Models\QualificationTest;
use Rimba\People\Models\Staff;
use RuntimeException;

final class BuildQualificationAttempt
{
    public function handle(QualificationTest $test, Staff $staff): QualificationAttempt
    {
        if ($test->status !== LearningStatus::Active) {
            throw new RuntimeException('Only active qualification tests can be attempted.');
        }

        if ($test->attempt_limit !== null && $test->attempts()->where('staff_id', $staff->getKey())->count() >= $test->attempt_limit) {
            throw new RuntimeException('The attempt limit has been reached.');
        }

        $staffUuid = (string) ($staff->uuid ?? '');
        if ($staffUuid === '') {
            throw new RuntimeException('The Staff record must expose a UUID for MES synchronization.');
        }

        return DB::transaction(function () use ($test, $staff, $staffUuid): QualificationAttempt {
            $qualificationAttempt = QualificationAttempt::query()->create([
                'qualification_test_id' => $test->getKey(),
                'staff_id' => $staff->getKey(),
                'staff_uuid' => $staffUuid,
                'status' => AttemptStatus::InProgress,
                'passing_score_snapshot' => $test->passing_score,
                'started_at' => now(),
            ]);

            $sequence = 0;
            $totalPoints = 0.0;
            foreach ($test->materials()->with('documentRevision')->orderBy('sequence')->get() as $material) {
                $bank = $material->documentRevision->questionBanks()
                    ->where('status', QuestionBankStatus::Active->value)
                    ->latest('reviewed_at')
                    ->first();
                if ($bank === null) {
                    throw new RuntimeException('Every test material must have an active question bank for its exact document revision.');
                }

                $limit = $material->question_limit ?? $test->question_limit;
                $query = $bank->questions()->where('is_active', true)->with('options')->inRandomOrder();
                $questions = $limit === null ? $query->get() : $query->limit($limit)->get();
                if ($questions->isEmpty()) {
                    throw new RuntimeException('An active question bank contains no selectable questions.');
                }

                foreach ($questions as $question) {
                    $sequence++;
                    $options = $question->options->map(fn ($option): array => [
                        'id' => (string) $option->getKey(),
                        'answer' => $option->answer,
                        'sequence' => $option->sequence,
                    ])->values()->all();
                    $correct = $question->options->where('is_correct', true)->map(fn ($option): string => (string) $option->getKey())->values()->all();
                    if ($correct === []) {
                        throw new RuntimeException('Every selected question must have at least one correct option.');
                    }

                    QualificationAnswer::query()->create([
                        'qualification_attempt_id' => $qualificationAttempt->getKey(),
                        'question_id' => $question->getKey(),
                        'question_uuid' => $question->getKey(),
                        'question_type' => $question->type->value,
                        'question_text' => $question->prompt,
                        'explanation' => $question->explanation,
                        'options_snapshot' => $options,
                        'correct_option_ids' => $correct,
                        'points' => $question->points,
                        'sequence' => $sequence,
                    ]);
                    $totalPoints += (float) $question->points;
                }
            }

            $qualificationAttempt->forceFill(['question_count' => $sequence, 'total_points' => $totalPoints])->save();

            return $qualificationAttempt->refresh()->load('answers');
        });
    }
}
