<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Actions;

use Rimba\Knowledge\Enums\RevisionStatus;
use Rimba\Knowledge\Models\DocumentRevision;
use RuntimeException;

final class ApplyDocumentRevisionDecision
{
    public function approve(DocumentRevision $revision, ?int $staffId = null): DocumentRevision
    {
        $this->ensurePending($revision);
        $revision->forceFill(['status' => RevisionStatus::Approved, 'approved_at' => now(), 'approved_by' => $staffId])->save();
        return $revision->refresh();
    }

    public function reject(DocumentRevision $revision, ?int $staffId = null): DocumentRevision
    {
        $this->ensurePending($revision);
        $revision->forceFill(['status' => RevisionStatus::Rejected, 'approved_at' => null, 'approved_by' => $staffId])->save();
        return $revision->refresh();
    }

    private function ensurePending(DocumentRevision $revision): void
    {
        if ($revision->status !== RevisionStatus::PendingApproval) {
            throw new RuntimeException('Only a pending document revision can receive an approval decision.');
        }
    }
}
