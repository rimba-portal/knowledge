<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rimba\Knowledge\Enums\LearningStatus;
use Rimba\Knowledge\Enums\ModuleDomain;
use Rimba\Organization\Models\OrgTeam;
use Rimba\Organization\Models\OrgUnit;

#[Table(name: 'kn_learning_modules')]
#[Fillable([
    'code',
    'name',
    'description',
    'org_unit_id',
    'org_team_id',
    'status',
    'estimated_minutes',
])]
class LearningModule extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'status' => LearningStatus::class,
            'estimated_minutes' => 'integer',
        ];
    }

    protected function moduleDomain(): Attribute
    {
        return Attribute::get(
            fn (): ?ModuleDomain => ModuleDomain::fromModuleCode(
                $this->code,
            ),
        );
    }

    public function orgUnit(): BelongsTo
    {
        return $this->belongsTo(OrgUnit::class);
    }

    public function orgTeam(): BelongsTo
    {
        return $this->belongsTo(OrgTeam::class);
    }

    public function moduleDocuments(): HasMany
    {
        return $this->hasMany(ModuleDocument::class);
    }

    public function documentRevisions(): BelongsToMany
    {
        return $this->belongsToMany(DocumentRevision::class, 'kn_module_documents')->withPivot(['sequence', 'is_required', 'completion_rule'])->withTimestamps();
    }
}
