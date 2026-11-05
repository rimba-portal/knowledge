<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rimba\Knowledge\Enums\QuestionBankStatus;
use Rimba\People\Models\Staff;

#[Table(name: 'kn_question_banks')]
#[Fillable([
    'document_revision_id',
    'name',
    'status',
    'reviewed_at',
    'reviewed_by',
])]
class QuestionBank extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'status' => QuestionBankStatus::class,
            'reviewed_at' => 'datetime',
        ];
    }

    public function documentRevision(): BelongsTo
    {
        return $this->belongsTo(DocumentRevision::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'reviewed_by');
    }
}
