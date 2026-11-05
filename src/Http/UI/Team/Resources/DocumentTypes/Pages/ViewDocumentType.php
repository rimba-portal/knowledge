<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentTypes\Pages;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentTypes\DocumentTypeResource;
class ViewDocumentType extends ViewRecord
{
    protected static string $resource = DocumentTypeResource::class;
    protected function getHeaderActions(): array { return [EditAction::make()]; }
}
