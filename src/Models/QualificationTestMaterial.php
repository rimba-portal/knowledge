<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table(name: 'kn_qualification_test_materials')]
#[Fillable([
    'qualification_test_id',
    'document_revision_id',
    'question_limit',
    'sequence',
])]
class QualificationTestMaterial extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'question_limit' => 'integer',
            'sequence' => 'integer',
        ];
    }

    public function qualificationTest(): BelongsTo
    {
        return $this->belongsTo(QualificationTest::class);
    }

    public function documentRevision(): BelongsTo
    {
        return $this->belongsTo(DocumentRevision::class);
    }
}
