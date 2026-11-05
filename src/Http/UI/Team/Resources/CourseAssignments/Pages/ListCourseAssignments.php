<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\CourseAssignments\Pages;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseAssignments\CourseAssignmentResource;
class ListCourseAssignments extends ListRecords
{
    protected static string $resource = CourseAssignmentResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
