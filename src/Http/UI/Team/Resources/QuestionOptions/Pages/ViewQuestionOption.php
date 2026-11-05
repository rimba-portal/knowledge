<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\QuestionOptions\Pages;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionOptions\QuestionOptionResource;
class ViewQuestionOption extends ViewRecord
{
    protected static string $resource = QuestionOptionResource::class;
    protected function getHeaderActions(): array { return [EditAction::make()]; }
}
