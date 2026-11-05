<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\QualificationTests\Pages;

use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Rimba\Knowledge\Actions\BuildQualificationAttempt;
use Rimba\Knowledge\Actions\GradeQualificationAttempt;
use Rimba\Knowledge\Contracts\CurrentStaffResolver;
use Rimba\Knowledge\Http\UI\Staff\Resources\QualificationTests\QualificationTestResource;
use Rimba\Knowledge\Models\QualificationAttempt;

final class TakeQualificationTest extends Page
{
    use InteractsWithRecord;

    protected static string $resource = QualificationTestResource::class;
    protected string $view = 'bites::knowledge.take-qualification-test';

    public ?string $attemptId = null;
    /** @var array<string, mixed> */
    public array $responses = [];

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function begin(BuildQualificationAttempt $builder, CurrentStaffResolver $staffResolver): void
    {
        abort_if($this->attemptId !== null, 409, 'An attempt is already active.');
        $this->attemptId = (string) $builder->handle($this->record, $staffResolver->resolve())->getKey();
    }

    public function submit(GradeQualificationAttempt $grader): void
    {
        abort_if($this->attemptId === null, 409, 'No attempt is active.');
        $grader->handle(QualificationAttempt::query()->findOrFail($this->attemptId), $this->responses);
        $this->responses = [];
    }

    public function getAttemptProperty(): ?QualificationAttempt
    {
        return $this->attemptId ? QualificationAttempt::query()->with('answers')->find($this->attemptId) : null;
    }
}
