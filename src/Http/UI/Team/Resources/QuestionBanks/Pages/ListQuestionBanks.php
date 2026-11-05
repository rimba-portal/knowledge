<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\Pages;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\QuestionBankResource;
class ListQuestionBanks extends ListRecords
{
    protected static string $resource = QuestionBankResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
