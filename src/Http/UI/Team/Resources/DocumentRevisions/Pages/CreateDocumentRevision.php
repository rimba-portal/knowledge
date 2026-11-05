<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\Pages;
use Filament\Resources\Pages\CreateRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\DocumentRevisionResource;
class CreateDocumentRevision extends CreateRecord { protected static string $resource = DocumentRevisionResource::class; }
