<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rimba\People\Models\Staff;

#[Table(name: 'kn_qualification_attempts')]
#[Fillable([
    'qualification_test_id',
    'staff_id',
    'staff_uuid',
    'status',
    'passing_score_snapshot',
    'question_count',
    'total_points',
    'earned_points',
    'score',
    'passed',
    'started_at',
    'submitted_at',
    'expires_at',
    'metadata',
])]
class QualificationAttempt extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'status' => \Rimba\Knowledge\Enums\AttemptStatus::class,
            'passing_score_snapshot' => 'decimal:2',
            'question_count' => 'integer',
            'total_points' => 'decimal:2',
            'earned_points' => 'decimal:2',
            'score' => 'decimal:2',
            'passed' => 'boolean',
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
            'expires_at' => 'datetime',
            'metadata' => 'array',
        ];
    }


    public function qualificationTest(): BelongsTo { return $this->belongsTo(QualificationTest::class); }
    public function staff(): BelongsTo { return $this->belongsTo(Staff::class); }
    public function answers(): HasMany { return $this->hasMany(QualificationAnswer::class)->orderBy('sequence'); }


}
