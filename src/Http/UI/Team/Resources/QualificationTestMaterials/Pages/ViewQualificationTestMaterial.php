<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationTestMaterials\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTestMaterials\QualificationTestMaterialResource;

class ViewQualificationTestMaterial extends ViewRecord
{
    protected static string $resource = QualificationTestMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make()];
    }
}
