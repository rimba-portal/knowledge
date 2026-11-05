<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules;

use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules\Pages\ListLearningModules;
use Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules\Pages\ViewLearningModule;
use Rimba\Knowledge\Models\LearningModule;

class LearningModuleResource extends Resource
{
    protected static ?string $model = LearningModule::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')->searchable(),
            TextColumn::make('name')->searchable(),
            TextColumn::make('estimated_minutes')->label('Minutes'),
        ])->recordActions([ViewAction::make()]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', 'active');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('code'),
            TextEntry::make('name'),
            TextEntry::make('description')->columnSpanFull(),
            RepeatableEntry::make('documentRevisions')->schema([
                TextEntry::make('document.code')->label('Document'),
                TextEntry::make('revision_code')->label('Revision'),
                TextEntry::make('title'),
            ])->columnSpanFull(),
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
