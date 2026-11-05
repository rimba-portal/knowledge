<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\ModuleDocuments\Pages;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\ModuleDocuments\ModuleDocumentResource;
class ViewModuleDocument extends ViewRecord
{
    protected static string $resource = ModuleDocumentResource::class;
    protected function getHeaderActions(): array { return [EditAction::make()]; }
}
