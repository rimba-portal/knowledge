<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentTypes\Pages;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentTypes\DocumentTypeResource;
class ListDocumentTypes extends ListRecords
{
    protected static string $resource = DocumentTypeResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
