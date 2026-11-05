<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table(name: 'kn_question_options')]
#[Fillable([
    'question_id',
    'answer',
    'is_correct',
    'sequence',
])]
class QuestionOption extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
            'sequence' => 'integer',
        ];
    }


    public function question(): BelongsTo { return $this->belongsTo(Question::class); }


}
