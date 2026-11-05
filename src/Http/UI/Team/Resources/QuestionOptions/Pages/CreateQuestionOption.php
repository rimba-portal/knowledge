<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QuestionOptions\Pages;

use Filament\Resources\Pages\CreateRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionOptions\QuestionOptionResource;

class CreateQuestionOption extends CreateRecord
{
    protected static string $resource = QuestionOptionResource::class;
}
