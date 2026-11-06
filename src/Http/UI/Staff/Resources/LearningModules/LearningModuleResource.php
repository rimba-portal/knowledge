<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules;

use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Enums\ModuleDomain;
use Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules\Pages\ListLearningModules;
use Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules\Pages\ViewLearningModule;
use Rimba\Knowledge\Models\LearningModule;
use UnitEnum;

class LearningModuleResource extends Resource
{
    protected static ?string $model = LearningModule::class;

    protected static string|BackedEnum|null $navigationIcon = 'bites-lms-module';

    protected static string|UnitEnum|null $navigationGroup = 'Learning';

    protected static ?int $navigationSort = 30;

    protected static ?string $navigationLabel = 'Modules';

    protected static ?string $modelLabel = 'learning module';

    protected static ?string $pluralModelLabel = 'learning modules';

    public static function getRecordRouteKeyName(): ?string
    {
        return 'code';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                LearningModule::query()
                    ->withCount([
                        'courses',
                        'documentRevisions',
                    ]),
            )
            ->recordUrl(
                fn (LearningModule $record): string => static::getUrl('view', [
                    'record' => $record->code,
                ]),
            )
            ->columns([
                TextColumn::make('module_domain')
                    ->label('Domain')
                    ->badge()
                    ->alignEnd()
                    ->formatStateUsing(
                        fn (?ModuleDomain $state): string => $state?->getLabel() ?? 'Other',
                    )
                    ->icon(
                        fn (?ModuleDomain $state): string|BackedEnum|null => $state?->getIcon(),
                    )
                    ->color(
                        fn (?ModuleDomain $state): string|array|null => $state?->getColor(),
                    )
                    ->tooltip(
                        fn (?ModuleDomain $state): ?string => $state?->getDescription(),
                    ),

                Split::make([
                    IconColumn::make('module_domain')
                        ->label('')
                        ->icon(
                            fn (?ModuleDomain $state): string|BackedEnum => $state?->getIcon()
                                ?? 'heroicon-o-book-open',
                        )
                        ->color(
                            fn (?ModuleDomain $state): string|array|null => $state?->getColor(),
                        )
                        ->tooltip(
                            fn (?ModuleDomain $state): ?string => $state?->getDescription(),
                        )
                        ->grow(false),

                    Stack::make([
                        TextColumn::make('name')
                            ->label('Module')
                            ->searchable()
                            ->weight(FontWeight::SemiBold)
                            ->color(
                                fn (LearningModule $record): string|array|null => $record->module_domain?->getColor(),
                            ),

                        TextColumn::make('code')
                            ->size(TextSize::ExtraSmall)
                            ->color('gray')
                            ->copyable(),

                        TextColumn::make('description')
                            ->size(TextSize::ExtraSmall)
                            ->searchable()
                            ->wrap()
                            ->limit(150),

                        TextColumn::make('estimated_minutes')
                            ->label('Duration')
                            ->size(TextSize::ExtraSmall)
                            ->icon('heroicon-o-clock')
                            ->formatStateUsing(
                                fn (?int $state): string => $state
                                        ? "{$state} min"
                                        : 'Duration not set',
                            )
                            ->color('gray'),
                    ]),
                ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->paginated(false)
            ->contentGrid([
                'md' => 1,
                'xl' => 4,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLearningModules::route('/'),
            'view' => ViewLearningModule::route('/{record}'),
        ];
    }
}
