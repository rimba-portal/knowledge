<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationTestMaterials\Pages;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTestMaterials\QualificationTestMaterialResource;
class ListQualificationTestMaterials extends ListRecords
{
    protected static string $resource = QualificationTestMaterialResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
