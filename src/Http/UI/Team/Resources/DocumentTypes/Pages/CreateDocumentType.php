<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentTypes\Pages;
use Filament\Resources\Pages\CreateRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentTypes\DocumentTypeResource;
class CreateDocumentType extends CreateRecord { protected static string $resource = DocumentTypeResource::class; }
