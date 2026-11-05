<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\CourseAssignments\Pages;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseAssignments\CourseAssignmentResource;
class ViewCourseAssignment extends ViewRecord
{
    protected static string $resource = CourseAssignmentResource::class;
    protected function getHeaderActions(): array { return [EditAction::make()]; }
}
