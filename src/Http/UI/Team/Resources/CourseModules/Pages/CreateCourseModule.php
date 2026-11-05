<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\CourseModules\Pages;
use Filament\Resources\Pages\CreateRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseModules\CourseModuleResource;
class CreateCourseModule extends CreateRecord { protected static string $resource = CourseModuleResource::class; }
