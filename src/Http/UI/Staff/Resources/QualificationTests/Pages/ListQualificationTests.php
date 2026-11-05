<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Staff\Resources\QualificationTests\Pages;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Knowledge\Http\UI\Staff\Resources\QualificationTests\QualificationTestResource;
class ListQualificationTests extends ListRecords
{
    protected static string $resource = QualificationTestResource::class;
    protected function getHeaderActions(): array { return []; }
}
