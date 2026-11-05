<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Actions;

use Illuminate\Support\Facades\DB;
use Rimba\Knowledge\Contracts\DocumentRevisionApprovalGateway;
use Rimba\Knowledge\Enums\RevisionStatus;
use Rimba\Knowledge\Models\DocumentRevision;
use RuntimeException;

final class SubmitDocumentRevisionForApproval
{
    public function __construct(private readonly DocumentRevisionApprovalGateway $documentRevisionApprovalGateway) {}

    public function handle(DocumentRevision $revision): DocumentRevision
    {
        if ($revision->status !== RevisionStatus::Draft && $revision->status !== RevisionStatus::Rejected) {
            throw new RuntimeException('Only draft or rejected revisions may be submitted.');
        }

        if ($revision->files()->count() === 0) {
            throw new RuntimeException('A document revision must have at least one file before submission.');
        }

        return DB::transaction(function () use ($revision): DocumentRevision {
            $revision->forceFill([
                'status' => RevisionStatus::PendingApproval,
                'submitted_at' => now(),
                'approved_at' => null,
                'approved_by' => null,
            ])->save();

            $runId = $this->documentRevisionApprovalGateway->submit($revision->fresh(['document']));
            if ($runId !== null) {
                $revision->forceFill(['workflow_run_id' => $runId])->save();
            }

            return $revision->refresh();
        });
    }
}
