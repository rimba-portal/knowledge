<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Staff\Resources\Courses\Pages;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Knowledge\Http\UI\Staff\Resources\Courses\CourseResource;
class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;
    protected function getHeaderActions(): array { return []; }
}
