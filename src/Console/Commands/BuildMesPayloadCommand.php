<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Rimba\Knowledge\Models\DocumentRevision;
use Rimba\Knowledge\Models\QualificationAttempt;
use Rimba\Knowledge\Models\QualificationTest;
use Rimba\Knowledge\Services\MesProjectionService;

#[Description('Print an IEC 62264/MESA projection for a Knowledge record.')]
#[Signature('knowledge:mes-payload {type : qualification-test|qualification-result|work-document-reference} {uuid} {--work-record=}')]
final class BuildMesPayloadCommand extends Command
{
    public function handle(MesProjectionService $projections): int
    {
        $payload = match ((string) $this->argument('type')) {
            'qualification-test' => $projections->qualificationTestSpecification(QualificationTest::query()->findOrFail($this->argument('uuid'))),
            'qualification-result' => $projections->qualificationTestResult(QualificationAttempt::query()->findOrFail($this->argument('uuid'))),
            'work-document-reference' => $projections->workDocumentReference(
                (string) $this->option('work-record'),
                DocumentRevision::query()->findOrFail($this->argument('uuid')),
            ),
            default => null,
        };

        if ($payload === null || (($this->argument('type') === 'work-document-reference') && blank($this->option('work-record')))) {
            $this->components->error('Unsupported type or missing --work-record value.');

            return self::FAILURE;
        }

        $this->line(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));

        return self::SUCCESS;
    }
}
