<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\CourseModules;

use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseModules\Pages\CreateCourseModule;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseModules\Pages\EditCourseModule;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseModules\Pages\ListCourseModules;
use Rimba\Knowledge\Http\UI\Team\Resources\CourseModules\Pages\ViewCourseModule;
use Rimba\Knowledge\Models\CourseModule;

class CourseModuleResource extends Resource
{
    protected static ?string $model = CourseModule::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('course_id')->relationship('course', 'name')->required()->searchable()->preload(),
            Select::make('learning_module_id')->relationship('learningModule', 'name')->required()->searchable()->preload(),
            TextInput::make('sequence')->numeric()->minValue(0)->default(0),
            Toggle::make('is_required')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('course.code')->label('Course'),
            TextColumn::make('learningModule.code')->label('Module'),
            TextColumn::make('sequence')->sortable(),
            IconColumn::make('is_required')->boolean(),
        ])->recordActions([ViewAction::make(), EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourseModules::route('/'),
            'create' => CreateCourseModule::route('/create'),
            'view' => ViewCourseModule::route('/{record}'),
            'edit' => EditCourseModule::route('/{record}/edit'),
        ];
    }
}
