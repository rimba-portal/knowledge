<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules;

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
        ])->recordActions([ViewAction::make(),]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('status', 'active');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Infolists\Components\TextEntry::make('code'),
            \Filament\Infolists\Components\TextEntry::make('name'),
            \Filament\Infolists\Components\TextEntry::make('description')->columnSpanFull(),
            \Filament\Infolists\Components\RepeatableEntry::make('documentRevisions')->schema([
                \Filament\Infolists\Components\TextEntry::make('document.code')->label('Document'),
                \Filament\Infolists\Components\TextEntry::make('revision_code')->label('Revision'),
                \Filament\Infolists\Components\TextEntry::make('title'),
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
