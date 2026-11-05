<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\CourseModules\Pages;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseModules\CourseModuleResource;
class EditCourseModule extends EditRecord
{
    protected static string $resource = CourseModuleResource::class;
    protected function getHeaderActions(): array { return [ViewAction::make(), DeleteAction::make()]; }
}
