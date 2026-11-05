<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Database\Seeders;

use Illuminate\Database\Seeder;
use Rimba\Knowledge\Enums\DocumentStatus;
use Rimba\Knowledge\Enums\RevisionStatus;
use Rimba\Knowledge\Models\Document;
use Rimba\Knowledge\Models\DocumentRevision;
use Rimba\Knowledge\Models\DocumentType;
use Rimba\Organization\Models\OrgUnit;

final class KnowledgeDemoSeeder extends Seeder
{
    public function run(): void
    {
        $orgUnit = OrgUnit::query()->first();
        if ($orgUnit === null) {
            $this->command?->warn('Knowledge demo seed skipped: create an OrgUnit first.');
            return;
        }

        $type = DocumentType::query()->firstOrCreate(['code' => 'WI'], ['name' => 'Work Instruction', 'is_active' => true]);
        $document = Document::query()->firstOrCreate(['code' => 'WI-DEMO-001'], [
            'name' => 'Demonstration Work Instruction',
            'document_type_id' => $type->getKey(),
            'org_unit_id' => $orgUnit->getKey(),
            'status' => DocumentStatus::Draft,
        ]);
        DocumentRevision::query()->firstOrCreate([
            'document_id' => $document->getKey(),
            'revision_code' => '01',
        ], ['title' => 'Initial revision', 'status' => RevisionStatus::Draft]);
    }
}
