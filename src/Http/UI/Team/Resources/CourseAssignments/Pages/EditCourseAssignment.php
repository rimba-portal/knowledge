<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\CourseAssignments\Pages;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseAssignments\CourseAssignmentResource;
class EditCourseAssignment extends EditRecord
{
    protected static string $resource = CourseAssignmentResource::class;
    protected function getHeaderActions(): array { return [ViewAction::make(), DeleteAction::make()]; }
}
