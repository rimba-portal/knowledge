<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\LearningModules\Pages;
use Filament\Resources\Pages\CreateRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\LearningModules\LearningModuleResource;
class CreateLearningModule extends CreateRecord { protected static string $resource = LearningModuleResource::class; }
