<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\ModuleDocuments\Pages;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\ModuleDocuments\ModuleDocumentResource;
class EditModuleDocument extends EditRecord
{
    protected static string $resource = ModuleDocumentResource::class;
    protected function getHeaderActions(): array { return [ViewAction::make(), DeleteAction::make()]; }
}
