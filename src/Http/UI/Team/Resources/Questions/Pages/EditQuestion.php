<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\Questions\Pages;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\Questions\QuestionResource;
class EditQuestion extends EditRecord
{
    protected static string $resource = QuestionResource::class;
    protected function getHeaderActions(): array { return [ViewAction::make(), DeleteAction::make()]; }
}
