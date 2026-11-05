<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MaterialsRelationManager extends RelationManager
{
    protected static string $relationship = 'materials';

    protected static ?string $title = 'Test materials';

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
            TextInput::make('question_limit')->label('Question limit')->numeric()->minValue(1),
            TextInput::make('sequence')->numeric()->minValue(0)->default(0)->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('sequence')->label('#')->sortable(),
            TextColumn::make('documentRevision.document.code')->label('Document')->searchable(),
            TextColumn::make('documentRevision.title')->label('Title')->wrap(),
            TextColumn::make('documentRevision.revision_code')->label('Revision')->badge(),
            TextColumn::make('question_limit')->label('Questions')->placeholder('Default'),
        ])->headerActions([
            CreateAction::make()->label('Add material'),
        ])->recordActions([
            EditAction::make(),
            DeleteAction::make(),
        ])->reorderable('sequence')->defaultSort('sequence');
    }
}
