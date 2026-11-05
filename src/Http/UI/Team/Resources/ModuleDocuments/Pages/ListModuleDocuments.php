<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\ModuleDocuments\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Knowledge\Http\UI\Team\Resources\ModuleDocuments\ModuleDocumentResource;

class ListModuleDocuments extends ListRecords
{
    protected static string $resource = ModuleDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
