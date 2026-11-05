<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Staff\Resources\Documents\Pages;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Knowledge\Http\UI\Staff\Resources\Documents\DocumentResource;
class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;
    protected function getHeaderActions(): array { return []; }
}
