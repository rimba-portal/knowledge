<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\LearningModules\Pages;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\LearningModules\LearningModuleResource;
class ViewLearningModule extends ViewRecord
{
    protected static string $resource = LearningModuleResource::class;
    protected function getHeaderActions(): array { return [EditAction::make()]; }
}
