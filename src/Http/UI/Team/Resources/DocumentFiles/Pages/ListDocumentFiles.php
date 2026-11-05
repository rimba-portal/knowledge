<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentFiles\Pages;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentFiles\DocumentFileResource;
class ListDocumentFiles extends ListRecords
{
    protected static string $resource = DocumentFileResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
