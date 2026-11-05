<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\LearningModules\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\LearningModules\LearningModuleResource;

class EditLearningModule extends EditRecord
{
    protected static string $resource = LearningModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [ViewAction::make(), DeleteAction::make()];
    }
}
