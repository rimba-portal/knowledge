<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Actions;

use Illuminate\Support\Facades\DB;
use Rimba\Knowledge\Enums\LearningStatus;
use Rimba\Knowledge\Enums\RevisionStatus;
use Rimba\Knowledge\Events\DocumentRevisionBecameEffective;
use Rimba\Knowledge\Models\DocumentRevision;
use Rimba\Knowledge\Models\QualificationTest;
use RuntimeException;

final class PublishDocumentRevision
{
    public function handle(DocumentRevision $revision, ?int $publisherId = null): DocumentRevision
    {
        if ($revision->status !== RevisionStatus::Approved) {
            throw new RuntimeException('Only an approved revision can become effective.');
        }

        $published = DB::transaction(function () use ($revision, $publisherId): DocumentRevision {
            $supersededIds = DocumentRevision::query()
                ->where('document_id', $revision->document_id)
                ->where('id', '!=', $revision->getKey())
                ->where('status', RevisionStatus::Effective->value)
                ->pluck('id');

            DocumentRevision::query()->whereKey($supersededIds)->update(['status' => RevisionStatus::Superseded->value]);

            if ($supersededIds->isNotEmpty()) {
                QualificationTest::query()
                    ->whereHas('materials', fn ($query) => $query->whereIn('document_revision_id', $supersededIds))
                    ->update(['status' => LearningStatus::ReviewRequired->value, 'review_required_at' => now()]);
            }

            $revision->forceFill([
                'status' => RevisionStatus::Effective,
                'issued_at' => $revision->issued_at ?? now(),
                'effective_at' => $revision->effective_at ?? now(),
                'published_by' => $publisherId,
            ])->save();

            $revision->document()->update(['current_revision_id' => $revision->getKey(), 'status' => 'active']);
            return $revision->refresh();
        });

        DocumentRevisionBecameEffective::dispatch($published);
        return $published;
    }
}
