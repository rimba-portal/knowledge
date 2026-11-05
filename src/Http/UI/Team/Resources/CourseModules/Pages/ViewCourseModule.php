<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\CourseModules\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseModules\CourseModuleResource;

class ViewCourseModule extends ViewRecord
{
    protected static string $resource = CourseModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make()];
    }
}
