<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\CourseAssignments\Pages;

use Filament\Resources\Pages\CreateRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseAssignments\CourseAssignmentResource;

class CreateCourseAssignment extends CreateRecord
{
    protected static string $resource = CourseAssignmentResource::class;
}
