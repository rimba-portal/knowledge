<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rimba\Organization\Models\OrgTeam;
use Rimba\Organization\Models\OrgUnit;

#[Table(name: 'kn_documents')]
#[Fillable([
    'code',
    'name',
    'description',
    'document_type_id',
    'org_unit_id',
    'org_team_id',
    'current_revision_id',
    'status',
    'external_attributes',
])]
class Document extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => \Rimba\Knowledge\Enums\DocumentStatus::class,
            'external_attributes' => 'array',
        ];
    }


    public function documentType(): BelongsTo { return $this->belongsTo(DocumentType::class); }
    public function orgUnit(): BelongsTo { return $this->belongsTo(OrgUnit::class); }
    public function orgTeam(): BelongsTo { return $this->belongsTo(OrgTeam::class); }
    public function currentRevision(): BelongsTo { return $this->belongsTo(DocumentRevision::class, 'current_revision_id'); }
    public function revisions(): HasMany { return $this->hasMany(DocumentRevision::class); }
    public function links(): HasMany { return $this->hasMany(DocumentLink::class); }


}
