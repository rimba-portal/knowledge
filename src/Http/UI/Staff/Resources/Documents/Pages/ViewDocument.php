<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\Documents\Pages;

use Filament\Resources\Pages\ViewRecord;
use Rimba\Knowledge\Http\UI\Staff\Resources\Documents\DocumentResource;

class ViewDocument extends ViewRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
