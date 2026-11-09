<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Rimba\Knowledge\Enums\KnowledgeRequirement;
use Rimba\Mesa\ResourceManagement\Models\JobRole;

#[Fillable([
    'uuid', 'knowledge_type', 'knowledge_id', 'job_role_uuid', 'scope_type', 'scope_id',
    'requirement', 'effective_from', 'effective_until', 'is_active', 'metadata',
])]
final class KnowledgeApplicability extends Model
{
    use HasUuids;

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function knowledge(): MorphTo
    {
        return $this->morphTo();
    }

    public function scope(): MorphTo
    {
        return $this->morphTo();
    }

    public function jobRole(): BelongsTo
    {
        return $this->belongsTo(JobRole::class, 'job_role_uuid', 'uuid');
    }

    #[Scope]
    protected function currentlyEffective(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(fn (Builder $q) => $q->whereNull('effective_from')->orWhere('effective_from', '<=', now()))
            ->where(fn (Builder $q) => $q->whereNull('effective_until')->orWhere('effective_until', '>=', now()));
    }

    protected function casts(): array
    {
        return [
            'requirement' => KnowledgeRequirement::class,
            'effective_from' => 'immutable_datetime',
            'effective_until' => 'immutable_datetime',
            'is_active' => 'boolean',
            'metadata' => 'array',
        ];
    }
}
