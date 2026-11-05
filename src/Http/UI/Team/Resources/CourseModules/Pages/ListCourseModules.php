<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\CourseModules\Pages;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseModules\CourseModuleResource;
class ListCourseModules extends ListRecords
{
    protected static string $resource = CourseModuleResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
