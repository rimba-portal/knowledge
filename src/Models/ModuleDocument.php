<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table(name: 'kn_module_documents')]
#[Fillable([
    'learning_module_id',
    'document_revision_id',
    'sequence',
    'is_required',
    'completion_rule',
])]
class ModuleDocument extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'sequence' => 'integer',
            'is_required' => 'boolean',
        ];
    }


    public function learningModule(): BelongsTo { return $this->belongsTo(LearningModule::class); }
    public function documentRevision(): BelongsTo { return $this->belongsTo(DocumentRevision::class); }


}
