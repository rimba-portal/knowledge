<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\Pages;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\DocumentRevisionResource;
class ListDocumentRevisions extends ListRecords
{
    protected static string $resource = DocumentRevisionResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
