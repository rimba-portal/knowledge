<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationAttempts\Pages;

use Filament\Resources\Pages\ViewRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationAttempts\QualificationAttemptResource;

class ViewQualificationAttempt extends ViewRecord
{
    protected static string $resource = QualificationAttemptResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
