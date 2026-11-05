<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\ModuleDocuments\Pages;

use Filament\Resources\Pages\CreateRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\ModuleDocuments\ModuleDocumentResource;

class CreateModuleDocument extends CreateRecord
{
    protected static string $resource = ModuleDocumentResource::class;
}
