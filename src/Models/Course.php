<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
            'status' => \Rimba\Knowledge\Enums\LearningStatus::class,
        ];
    }


    public function orgUnit(): BelongsTo { return $this->belongsTo(OrgUnit::class); }
    public function orgTeam(): BelongsTo { return $this->belongsTo(OrgTeam::class); }
    public function modules(): BelongsToMany { return $this->belongsToMany(LearningModule::class, 'kn_course_modules')->withPivot(['sequence','is_required'])->withTimestamps(); }
    public function courseModules(): HasMany { return $this->hasMany(CourseModule::class); }
    public function assignments(): HasMany { return $this->hasMany(CourseAssignment::class); }


}
