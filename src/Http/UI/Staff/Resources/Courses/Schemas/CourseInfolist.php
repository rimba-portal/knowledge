<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\Courses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Rimba\Knowledge\Enums\LearningStatus;
use Rimba\Knowledge\Models\Course;

final class CourseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Course')
                    ->schema([
                        TextEntry::make('code')
                            ->label('Code')
                            ->badge()
                            ->color('gray')
                            ->copyable(),

                        TextEntry::make('name')
                            ->label('Course')
                            ->weight('semibold'),

                        TextEntry::make('status')
                            ->badge()
                            ->formatStateUsing(
                                fn (
                                    LearningStatus|string|null $state,
                                ): string => str(
                                    $state instanceof LearningStatus
                                        ? $state->value
                                        : (string) $state,
                                )
                                    ->replace('_', ' ')
                                    ->title()
                                    ->toString(),
                            )
                            ->color(
                                fn (
                                    LearningStatus|string|null $state,
                                ): string => match (
                                    $state instanceof LearningStatus
                                        ? $state
                                        : LearningStatus::tryFrom(
                                            (string) $state,
                                        )
                                ) {
                                    LearningStatus::Active => 'success',
                                    LearningStatus::ReviewRequired => 'warning',
                                    LearningStatus::Retired => 'gray',
                                    default => 'info',
                                },
                            ),

                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull()
                            ->prose()
                            ->placeholder(
                                'No course description has been provided.',
                            ),
                    ])
                    ->columns([
                        'md' => 3,
                    ]),

                Section::make('Availability')
                    ->schema([
                        TextEntry::make('orgUnit.name')
                            ->label('Owning unit')
                            ->placeholder('Not specified'),

                        TextEntry::make('orgTeam.name')
                            ->label('Managing team')
                            ->placeholder(
                                'Available across the owning unit',
                            ),

                        TextEntry::make('modules_count')
                            ->label('Learning modules')
                            ->state(
                                fn (Course $record): int => (int) (
                                    $record->modules_count
                                    ?? $record->modules()->count()
                                ),
                            )
                            ->formatStateUsing(
                                fn (int|string|null $state): string => sprintf(
                                    '%d %s',
                                    (int) $state,
                                    str('module')->plural((int) $state),
                                ),
                            ),
                    ])
                    ->columns([
                        'md' => 3,
                    ]),
            ]);
    }
}
