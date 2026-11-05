<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\Pages;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\DocumentRevisionResource;
class ViewDocumentRevision extends ViewRecord
{
    protected static string $resource = DocumentRevisionResource::class;
    protected function getHeaderActions(): array { return [EditAction::make()]; }
}
