<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\Pages;

use Filament\Resources\Pages\CreateRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\QuestionBankResource;

class CreateQuestionBank extends CreateRecord
{
    protected static string $resource = QuestionBankResource::class;
}
