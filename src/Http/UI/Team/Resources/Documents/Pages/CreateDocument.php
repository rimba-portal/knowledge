<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\Documents\Pages;

use Filament\Resources\Pages\CreateRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\Documents\DocumentResource;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;
}
