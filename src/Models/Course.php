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
use Rimba\Knowledge\Enums\CourseType;
use Rimba\Knowledge\Enums\LearningStatus;
use Rimba\Organization\Models\OrgTeam;
use Rimba\Organization\Models\OrgUnit;

#[Table(name: 'kn_courses')]
#[Fillable([
    'code',
    'name',
    'description',
    'org_unit_id',
    'org_team_id',
    'status',
])]
class Course extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'status' => LearningStatus::class,
        ];
    }

    /**
     * Determine the course purpose from its code prefix.
     *
     * Examples:
     * IND-001 => Induction
     * QLF-003 => Qualification
     * CMP-001 => Compliance
     */
    protected function courseType(): Attribute
    {
        return Attribute::get(
            fn (): ?CourseType => CourseType::fromCourseCode(
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

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(LearningModule::class, 'kn_course_modules')->withPivot(['sequence', 'is_required'])->withTimestamps();
    }

    public function courseModules(): HasMany
    {
        return $this->hasMany(CourseModule::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(CourseAssignment::class);
    }
}
