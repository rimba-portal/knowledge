<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Actions;

use Illuminate\Support\Facades\DB;
use Rimba\Knowledge\Enums\AttemptStatus;
use Rimba\Knowledge\Events\QualificationAttemptCompleted;
use Rimba\Knowledge\Models\QualificationAttempt;
use Rimba\Knowledge\Services\ScoreCalculator;
use RuntimeException;

final class GradeQualificationAttempt
{
    public function __construct(private readonly ScoreCalculator $calculator) {}

    /** @param array<string, mixed> $responses */
    public function handle(QualificationAttempt $attempt, array $responses): QualificationAttempt
    {
        $graded = DB::transaction(function () use ($attempt, $responses): QualificationAttempt {
            $attempt = QualificationAttempt::query()->lockForUpdate()->findOrFail($attempt->getKey());
            if ($attempt->status !== AttemptStatus::InProgress) {
                throw new RuntimeException('Only an in-progress attempt may be submitted.');
            }

            $earned = 0.0;
            foreach ($attempt->answers()->get() as $answer) {
                $raw = $responses[(string) $answer->question_uuid] ?? [];
                $selected = is_array($raw) ? array_keys(array_filter($raw, fn ($value) => $value !== false && $value !== null && $value !== '')) : [$raw];
                if (array_is_list((array) $raw)) {
                    $selected = (array) $raw;
                }
                $selected = array_values(array_filter(array_map('strval', $selected)));
                $allowed = collect($answer->options_snapshot)->pluck('id')->map('strval')->all();
                if (array_diff($selected, $allowed) !== []) {
                    throw new RuntimeException('A submitted answer contains an option outside the frozen question snapshot.');
                }

                $isCorrect = $this->calculator->isExactMatch($selected, $answer->correct_option_ids);
                $points = $isCorrect ? (float) $answer->points : 0.0;
                $answer->forceFill(['selected_option_ids' => $selected, 'earned_points' => $points, 'is_correct' => $isCorrect])->save();
                $earned += $points;
            }

            $score = $this->calculator->percentage($earned, (float) $attempt->total_points);
            $passed = $score >= (float) $attempt->passing_score_snapshot;
            $validityDays = $attempt->qualificationTest->validity_days;
            $attempt->forceFill([
                'status' => AttemptStatus::Submitted,
                'earned_points' => $earned,
                'score' => $score,
                'passed' => $passed,
                'submitted_at' => now(),
                'expires_at' => $passed && $validityDays ? now()->addDays($validityDays) : null,
            ])->save();

            return $attempt->refresh()->load(['answers', 'qualificationTest']);
        });

        QualificationAttemptCompleted::dispatch($graded);
        return $graded;
    }
}
