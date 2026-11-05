<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationTestMaterials\Pages;

use Filament\Resources\Pages\CreateRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTestMaterials\QualificationTestMaterialResource;

class CreateQualificationTestMaterial extends CreateRecord
{
    protected static string $resource = QualificationTestMaterialResource::class;
}
