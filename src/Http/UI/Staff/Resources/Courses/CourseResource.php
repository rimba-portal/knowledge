<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\Courses;

use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Rimba\Knowledge\Http\UI\Staff\Resources\Courses\Pages\ListCourses;
use Rimba\Knowledge\Http\UI\Staff\Resources\Courses\Pages\ViewCourse;
use Rimba\Knowledge\Models\Course;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Learning';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $navigationLabel = 'My courses';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')->searchable()->copyable()->weight('semibold'),
            TextColumn::make('name')->label('Course')->searchable(),
            TextColumn::make('modules_count')->counts('modules')->label('Modules'),
            TextColumn::make('orgUnit.name')->label('Owner')->toggleable(),
        ])->recordActions([ViewAction::make()])->defaultSort('code');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Course')->schema([
                TextEntry::make('code')->copyable(),
                TextEntry::make('name'),
                TextEntry::make('orgUnit.name')->label('Owner'),
                TextEntry::make('description')->columnSpanFull()->placeholder('—'),
            ])->columns(2),
            Section::make('Modules')->schema([
                RepeatableEntry::make('courseModules')->label('')->schema([
                    TextEntry::make('sequence')->label('#'),
                    TextEntry::make('learningModule.code')->label('Code'),
                    TextEntry::make('learningModule.name')->label('Learning module'),
                    TextEntry::make('learningModule.estimated_minutes')->label('Duration')->suffix(' min')->placeholder('—'),
                    IconEntry::make('is_required')->label('Required')->boolean(),
                ])->columns(5)->columnSpanFull(),
            ]),
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', 'active')->with(['orgUnit', 'courseModules.learningModule']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourses::route('/'),
            'view' => ViewCourse::route('/{record}'),
        ];
    }
}
