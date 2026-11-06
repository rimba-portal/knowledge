<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\Courses\RelationManagers;

use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules\LearningModuleResource;

class ModulesRelationManager extends RelationManager
{
    protected static string $relationship = 'modules';

    protected static ?string $relatedResource =
        LearningModuleResource::class;

    protected static ?string $title = 'Learning modules';

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('sequence')
            ->columns([
                TextColumn::make('sequence')
                    ->label('#')
                    ->alignCenter(),

                TextColumn::make('code')
                    ->label('Code')
                    ->badge()
                    ->color('gray')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Module')
                    ->description(
                        fn ($record): ?string => $record->description,
                    )
                    ->searchable()
                    ->wrap(),

                TextColumn::make('estimated_minutes')
                    ->label('Duration')
                    ->alignEnd()
                    ->formatStateUsing(
                        fn (
                            int|string|null $state,
                        ): string => filled($state)
                            ? sprintf('%d min', (int) $state)
                            : 'Self-paced',
                    ),

                IconColumn::make('is_required')
                    ->label('Required')
                    ->boolean()
                    ->alignCenter(),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->paginated(false)
            ->emptyStateHeading('No learning modules')
            ->emptyStateDescription(
                'This course does not contain any learning modules yet.',
            );
    }
}
