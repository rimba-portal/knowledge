<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\CourseAssignments;

use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseAssignments\Pages\ListCourseAssignments;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseAssignments\Pages\ViewCourseAssignment;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseAssignments\Pages\CreateCourseAssignment;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseAssignments\Pages\EditCourseAssignment;
use Rimba\Knowledge\Models\CourseAssignment;

class CourseAssignmentResource extends Resource
{
    protected static ?string $model = CourseAssignment::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('course_id')->relationship('course', 'name')->required()->searchable()->preload(),
            Select::make('staff_id')->relationship('staff', 'name')->required()->searchable()->preload(),
            DateTimePicker::make('assigned_at')->default(now()),
            DateTimePicker::make('due_at'),
            Select::make('status')->options(\Rimba\Knowledge\Enums\AssignmentStatus::class)->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('course.code')->label('Course'),
            TextColumn::make('staff.name')->label('Staff')->searchable(),
            TextColumn::make('status')->badge(),
            TextColumn::make('due_at')->dateTime(),
            TextColumn::make('progress_percentage')->suffix('%'),
        ])->recordActions([ViewAction::make(), EditAction::make(),]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourseAssignments::route('/'),
            'create' => CreateCourseAssignment::route('/create'),
            'view' => ViewCourseAssignment::route('/{record}'),
            'edit' => EditCourseAssignment::route('/{record}/edit'),
        ];
    }
}
