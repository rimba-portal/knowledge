<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table(name: 'kn_qualification_answers')]
#[Fillable([
    'qualification_attempt_id',
    'question_id',
    'question_uuid',
    'question_type',
    'question_text',
    'explanation',
    'options_snapshot',
    'correct_option_ids',
    'selected_option_ids',
    'points',
    'earned_points',
    'is_correct',
    'sequence',
])]
class QualificationAnswer extends Model
{
    use HasUuids;

    protected $hidden = ['correct_option_ids'];

    protected function casts(): array
    {
        return [
            'options_snapshot' => 'array',
            'correct_option_ids' => 'array',
            'selected_option_ids' => 'array',
            'points' => 'decimal:2',
            'earned_points' => 'decimal:2',
            'is_correct' => 'boolean',
            'sequence' => 'integer',
        ];
    }


    public function qualificationAttempt(): BelongsTo { return $this->belongsTo(QualificationAttempt::class); }
    public function question(): BelongsTo { return $this->belongsTo(Question::class); }


}
