<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\Courses;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Rimba\Knowledge\Enums\LearningStatus;
use Rimba\Knowledge\Http\UI\Staff\Resources\Courses\Pages\ListCourses;
use Rimba\Knowledge\Http\UI\Staff\Resources\Courses\Pages\ViewCourse;
use Rimba\Knowledge\Http\UI\Staff\Resources\Courses\RelationManagers\ModulesRelationManager;
use Rimba\Knowledge\Http\UI\Staff\Resources\Courses\Schemas\CourseInfolist;
use Rimba\Knowledge\Models\Course;
use UnitEnum;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string|BackedEnum|null $navigationIcon = 'bites-lms-course';

    protected static string|UnitEnum|null $navigationGroup = 'Learning';

    protected static ?int $navigationSort = 25;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getRecordRouteKeyName(): ?string
    {
        return 'code';
    }

    public static function infolist(Schema $schema): Schema
    {
        return CourseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(
                fn (Course $record): string => static::getUrl('view', [
                    'record' => $record->code,
                ]),
            )
            ->columns([
                Stack::make([
                    Split::make([
                        TextColumn::make('orgUnit.name')
                            ->label('Owning unit')
                            ->badge()
                            ->color('gray')
                            ->placeholder('Enterprise'),

                        TextColumn::make('modules_count')
                            ->label('')
                            ->badge()
                            ->color('primary')
                            ->alignEnd()
                            ->formatStateUsing(
                                fn (int|string|null $state): string => sprintf(
                                    '%d %s',
                                    (int) $state,
                                    str('module')->plural((int) $state),
                                ),
                            ),
                    ]),

                    TextColumn::make('name')
                        ->label('Course')
                        ->searchable()
                        ->weight(FontWeight::SemiBold)
                        ->size(TextSize::Large)
                        ->wrap(),

                    TextColumn::make('code')
                        ->label('Code')
                        ->searchable()
                        ->badge()
                        ->color('gray')
                        ->size(TextSize::ExtraSmall),

                    TextColumn::make('description')
                        ->label('')
                        ->searchable()
                        ->limit(160)
                        ->wrap()
                        ->placeholder(
                            'No course description has been provided.',
                        ),

                    TextColumn::make('orgTeam.name')
                        ->label('Managing team')
                        ->icon('heroicon-o-user-group')
                        ->color('gray')
                        ->size(TextSize::ExtraSmall)
                        ->placeholder(
                            'Available across the owning unit',
                        ),
                ])
                    ->space(3),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 4,
            ])
            ->paginated(false);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status', LearningStatus::Active->value)
            ->with(['orgUnit', 'orgTeam'])
            ->withCount('modules');
    }

    public static function getRelations(): array
    {
        return [
            ModulesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourses::route('/'),
            'view' => ViewCourse::route('/{record}'),
        ];
    }
}
