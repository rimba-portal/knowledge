<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Services;

use Illuminate\Support\Collection;
use Rimba\Knowledge\Models\DocumentRevision;
use Rimba\Knowledge\Models\QualificationAttempt;
use Rimba\Knowledge\Models\QualificationTest;
use Rimba\Knowledge\Support\StableUuid;

final class MesProjectionService
{
    /** @return array<string, mixed> */
    public function qualificationTestSpecification(QualificationTest $test): array
    {
        return [
            'uuid' => (string) $test->getKey(),
            'job_role_uuid' => $test->job_role_uuid,
            'test_code' => $test->code,
            'passing_score' => (float) $test->passing_score,
        ];
    }

    /** @return array<string, mixed> */
    public function qualificationTestResult(QualificationAttempt $attempt): array
    {
        return [
            'uuid' => (string) $attempt->getKey(),
            'qualification_test_specification_uuid' => (string) $attempt->qualification_test_id,
            'staff_uuid' => (string) $attempt->staff_uuid,
            'score' => $attempt->score === null ? null : (float) $attempt->score,
            'expiry_date' => $attempt->expires_at?->toDateString(),
        ];
    }

    /** @param Collection<int, QualificationAttempt> $attempts @return array<string, mixed> */
    public function personnelCapability(string $staffUuid, Collection $attempts): array
    {
        $namespace = (string) config('bites.knowledge.mes.namespace_uuid');

        return [
            'uuid' => StableUuid::v5($namespace, 'personnel-capability:'.$staffUuid),
            'staff_uuid' => $staffUuid,
            'skills_verified_json' => $attempts
                ->filter(fn (QualificationAttempt $attempt): bool => $attempt->passed === true)
                ->map(fn (QualificationAttempt $attempt): array => [
                    'qualification_code' => $attempt->qualificationTest?->code,
                    'test_uuid' => (string) $attempt->qualification_test_id,
                    'result_uuid' => (string) $attempt->getKey(),
                    'passed' => true,
                    'qualified_at' => $attempt->submitted_at?->toAtomString(),
                    'valid_until' => $attempt->expires_at?->toAtomString(),
                ])->values()->all(),
        ];
    }

    /** @return array<string, mixed> */
    public function workDocumentReference(string $workRecordUuid, DocumentRevision $revision): array
    {
        $namespace = (string) config('bites.knowledge.mes.namespace_uuid');
        $documentUuid = (string) $revision->document_id;
        $name = implode(':', [$workRecordUuid, $documentUuid, $revision->revision_code]);

        return [
            'uuid' => StableUuid::v5($namespace, 'work-document-reference:'.$name),
            'work_record_uuid' => $workRecordUuid,
            'dms_document_uuid' => $documentUuid,
            'revision_code' => $revision->revision_code,
        ];
    }
}
