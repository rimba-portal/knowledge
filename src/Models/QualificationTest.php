<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rimba\Organization\Models\OrgTeam;
use Rimba\Organization\Models\OrgUnit;

#[Table(name: 'kn_qualification_tests')]
#[Fillable([
    'code',
    'name',
    'description',
    'org_unit_id',
    'org_team_id',
    'job_role_uuid',
    'passing_score',
    'question_limit',
    'attempt_limit',
    'validity_days',
    'status',
    'review_required_at',
])]
class QualificationTest extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'passing_score' => 'decimal:2',
            'question_limit' => 'integer',
            'attempt_limit' => 'integer',
            'validity_days' => 'integer',
            'status' => \Rimba\Knowledge\Enums\LearningStatus::class,
            'review_required_at' => 'datetime',
        ];
    }


    public function orgUnit(): BelongsTo { return $this->belongsTo(OrgUnit::class); }
    public function orgTeam(): BelongsTo { return $this->belongsTo(OrgTeam::class); }
    public function materials(): HasMany { return $this->hasMany(QualificationTestMaterial::class); }
    public function attempts(): HasMany { return $this->hasMany(QualificationAttempt::class); }


}
