<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\QualificationTestResource;

class ViewQualificationTest extends ViewRecord
{
    protected static string $resource = QualificationTestResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make()];
    }
}
