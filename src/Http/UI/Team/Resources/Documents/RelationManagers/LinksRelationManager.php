<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\Documents\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LinksRelationManager extends RelationManager
{
    protected static string $relationship = 'links';

    protected static ?string $title = 'Related records';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('target_type')
                ->label('Record type')
                ->options([
                    'equipment' => 'Equipment',
                    'material' => 'Material',
                    'process' => 'Process',
                    'job_role' => 'Job role',
                ])
                ->searchable()
                ->required(),
            TextInput::make('target_uuid')
                ->label('Record UUID')
                ->uuid()
                ->required(),
            Select::make('relationship')
                ->options([
                    'related' => 'Related',
                    'governs' => 'Governs',
                    'applies_to' => 'Applies to',
                    'supersedes' => 'Supersedes',
                ])
                ->default('related')
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('target_type')->label('Type')->badge(),
                TextColumn::make('target_uuid')->label('Record')->copyable()->limit(18),
                TextColumn::make('relationship')->badge(),
            ])
            ->headerActions([CreateAction::make()->label('Add link')])
            ->recordActions([EditAction::make(), DeleteAction::make()]);
    }
}
