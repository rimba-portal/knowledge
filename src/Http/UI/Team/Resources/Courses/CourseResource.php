<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\Courses;

use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Enums\LearningStatus;
use Rimba\Knowledge\Http\UI\Team\Resources\Courses\Pages\CreateCourse;
use Rimba\Knowledge\Http\UI\Team\Resources\Courses\Pages\EditCourse;
use Rimba\Knowledge\Http\UI\Team\Resources\Courses\Pages\ListCourses;
use Rimba\Knowledge\Http\UI\Team\Resources\Courses\Pages\ViewCourse;
use Rimba\Knowledge\Http\UI\Team\Resources\Courses\RelationManagers\AssignmentsRelationManager;
use Rimba\Knowledge\Http\UI\Team\Resources\Courses\RelationManagers\ModulesRelationManager;
use Rimba\Knowledge\Models\Course;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Course')->schema([
                TextInput::make('code')->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('name')->required()->maxLength(255),
                Textarea::make('description')->rows(4)->columnSpanFull(),
            ])->columns(2),
            Section::make('Ownership')->schema([
                Select::make('org_unit_id')->label('Owning unit')->relationship('orgUnit', 'name')->required()->searchable()->preload(),
                Select::make('org_team_id')->label('Managing team')->relationship('orgTeam', 'name')->searchable()->preload(),
                Select::make('status')->options(LearningStatus::class)->default(LearningStatus::Draft->value)->required(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')->searchable()->sortable()->copyable()->weight('semibold'),
            TextColumn::make('name')->label('Course')->searchable()->sortable(),
            TextColumn::make('course_modules_count')->counts('courseModules')->label('Modules'),
            TextColumn::make('orgUnit.name')->label('Owner')->toggleable(),
            TextColumn::make('status')->badge()->sortable(),
        ])->recordActions([ViewAction::make(), EditAction::make()])->defaultSort('code');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Course')->schema([
                TextEntry::make('code')->copyable(),
                TextEntry::make('name'),
                TextEntry::make('status')->badge(),
                TextEntry::make('orgUnit.name')->label('Owning unit'),
                TextEntry::make('orgTeam.name')->label('Managing team')->placeholder('—'),
                TextEntry::make('description')->columnSpanFull()->placeholder('—'),
            ])->columns(2),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            'modules' => ModulesRelationManager::class,
            'assignments' => AssignmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourses::route('/'),
            'create' => CreateCourse::route('/create'),
            'view' => ViewCourse::route('/{record}'),
            'edit' => EditCourse::route('/{record}/edit'),
        ];
    }
}
