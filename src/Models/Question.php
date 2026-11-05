<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table(name: 'kn_questions')]
#[Fillable([
    'question_bank_id',
    'type',
    'prompt',
    'explanation',
    'points',
    'sequence',
    'is_active',
    'metadata',
])]
class Question extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'type' => \Rimba\Knowledge\Enums\QuestionType::class,
            'points' => 'decimal:2',
            'sequence' => 'integer',
            'is_active' => 'boolean',
            'metadata' => 'array',
        ];
    }


    public function questionBank(): BelongsTo { return $this->belongsTo(QuestionBank::class); }
    public function options(): HasMany { return $this->hasMany(QuestionOption::class)->orderBy('sequence'); }


}
