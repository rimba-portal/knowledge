<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\QuestionBankResource;

class ViewQuestionBank extends ViewRecord
{
    protected static string $resource = QuestionBankResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make()];
    }
}
