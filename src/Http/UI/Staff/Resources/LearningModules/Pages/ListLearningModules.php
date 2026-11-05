<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules\Pages;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules\LearningModuleResource;
class ListLearningModules extends ListRecords
{
    protected static string $resource = LearningModuleResource::class;
    protected function getHeaderActions(): array { return []; }
}
