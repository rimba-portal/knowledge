<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[Table(name: 'kn_document_types')]
#[Fillable([
    'code',
    'name',
    'description',
    'is_active',
])]
class DocumentType extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }


    public function documents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Document::class, 'document_type_id');
    }


}
