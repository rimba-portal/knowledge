<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table(name: 'kn_course_modules')]
#[Fillable([
    'course_id',
    'learning_module_id',
    'sequence',
    'is_required',
])]
class CourseModule extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'sequence' => 'integer',
            'is_required' => 'boolean',
        ];
    }


    public function course(): BelongsTo { return $this->belongsTo(Course::class); }
    public function learningModule(): BelongsTo { return $this->belongsTo(LearningModule::class); }


}
