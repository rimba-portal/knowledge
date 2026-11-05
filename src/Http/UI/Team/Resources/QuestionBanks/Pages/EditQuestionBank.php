<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\Pages;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\QuestionBankResource;
class EditQuestionBank extends EditRecord
{
    protected static string $resource = QuestionBankResource::class;
    protected function getHeaderActions(): array { return [ViewAction::make(), DeleteAction::make()]; }
}
