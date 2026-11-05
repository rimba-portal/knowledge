<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\LearningModules\RelationManagers;

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

class MaterialsRelationManager extends RelationManager
{
    protected static string $relationship = 'moduleDocuments';

    protected static ?string $title = 'Learning materials';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('document_revision_id')
                ->label('Document revision')
                ->relationship('documentRevision', 'title')
                ->getOptionLabelFromRecordUsing(fn ($record): string => "{$record->document?->code} · Rev {$record->revision_code} — {$record->title}")
                ->searchable(['title', 'revision_code'])
                ->preload()
                ->required(),
            Select::make('completion_rule')->label('Completion')->options([
                'view' => 'View',
                'acknowledge' => 'Acknowledge',
                'pass_test' => 'Pass test',
            ])->default('view')->required(),
            TextInput::make('sequence')->numeric()->minValue(0)->default(0)->required(),
            Toggle::make('is_required')->label('Required')->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('sequence')->label('#')->sortable(),
            TextColumn::make('documentRevision.document.code')->label('Document')->searchable(),
            TextColumn::make('documentRevision.title')->label('Title')->wrap(),
            TextColumn::make('documentRevision.revision_code')->label('Revision')->badge(),
            TextColumn::make('completion_rule')->label('Completion')->badge(),
            IconColumn::make('is_required')->label('Required')->boolean(),
        ])->headerActions([
            CreateAction::make()->label('Add material'),
        ])->recordActions([
            EditAction::make(),
            DeleteAction::make(),
        ])->reorderable('sequence')->defaultSort('sequence');
    }
}
