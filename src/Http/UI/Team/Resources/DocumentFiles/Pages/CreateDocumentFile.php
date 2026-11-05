<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentFiles\Pages;
use Filament\Resources\Pages\CreateRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentFiles\DocumentFileResource;
class CreateDocumentFile extends CreateRecord { protected static string $resource = DocumentFileResource::class; }
