<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\Courses\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ModulesRelationManager extends RelationManager
{
    protected static string $relationship = 'courseModules';

    protected static ?string $title = 'Modules';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('learning_module_id')
                ->label('Learning module')
                ->relationship('learningModule', 'name')
                ->getOptionLabelFromRecordUsing(fn ($record): string => "{$record->code} — {$record->name}")
                ->searchable(['code', 'name'])
                ->preload()
                ->required(),
            TextInput::make('sequence')->numeric()->minValue(0)->default(0)->required(),
            Toggle::make('is_required')->label('Required')->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('sequence')->label('#')->sortable(),
            TextColumn::make('learningModule.code')->label('Code')->searchable(),
            TextColumn::make('learningModule.name')->label('Learning module')->searchable()->wrap(),
            TextColumn::make('learningModule.estimated_minutes')->label('Duration')->suffix(' min')->placeholder('—'),
            IconColumn::make('is_required')->label('Required')->boolean(),
        ])->headerActions([
            CreateAction::make()->label('Add module'),
        ])->recordActions([
            EditAction::make(),
            DeleteAction::make(),
        ])->reorderable('sequence')->defaultSort('sequence');
    }
}
