<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\Questions\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\Questions\QuestionResource;

class ViewQuestion extends ViewRecord
{
    protected static string $resource = QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make()];
    }
}
