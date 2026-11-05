<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Packstub\Flow\Models\WorkflowRun;
use Rimba\Knowledge\Enums\RevisionStatus;
use Rimba\People\Models\Staff;
use Rimba\Request\Concerns\HasWorkflows;

#[Table(name: 'kn_document_revisions')]
#[Fillable([
    'document_id',
    'revision_code',
    'title',
    'summary',
    'change_notes',
    'status',
    'workflow_id',
    'workflow_run_id',
    'submitted_at',
    'approved_at',
    'approved_by',
    'issued_at',
    'effective_at',
    'expires_at',
    'published_by',
])]
class DocumentRevision extends Model
{
    use HasUuids;
    use HasWorkflows;

    protected function casts(): array
    {
        return [
            'status' => RevisionStatus::class,
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'issued_at' => 'datetime',
            'effective_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(DocumentFile::class);
    }

    public function questionBanks(): HasMany
    {
        return $this->hasMany(QuestionBank::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'approved_by');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'published_by');
    }

    public function workflowRun(): BelongsTo
    {
        return $this->belongsTo(WorkflowRun::class, 'workflow_run_id');
    }
}
