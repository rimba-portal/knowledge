<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Rimba\Knowledge\Enums\AssignmentStatus;
use Rimba\People\Models\Staff;

#[Table(name: 'kn_course_assignments')]
#[Fillable([
    'course_id',
    'staff_id',
    'assigned_by',
    'assigned_at',
    'due_at',
    'status',
    'progress_percentage',
    'completed_at',
    'metadata',
])]
class CourseAssignment extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'due_at' => 'datetime',
            'status' => AssignmentStatus::class,
            'progress_percentage' => 'decimal:2',
            'completed_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function assigner(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assigned_by');
    }
}
