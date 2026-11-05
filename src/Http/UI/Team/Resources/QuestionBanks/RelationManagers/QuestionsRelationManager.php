<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Enums\QuestionType;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    protected static ?string $recordTitleAttribute = 'prompt';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('type')->options(QuestionType::class)->required(),
            TextInput::make('points')->numeric()->minValue(0.01)->default(1)->required(),
            TextInput::make('sequence')->numeric()->minValue(0)->default(0)->required(),
            Toggle::make('is_active')->label('Active')->default(true),
            Textarea::make('prompt')->required()->rows(3)->columnSpanFull(),
            Textarea::make('explanation')->rows(3)->columnSpanFull(),
            Repeater::make('options')
                ->label('Answers')
                ->relationship()
                ->orderColumn('sequence')
                ->schema([
                    Textarea::make('answer')->required()->rows(2),
                    Toggle::make('is_correct')->label('Correct'),
                ])
                ->columns(2)
                ->minItems(2)
                ->addActionLabel('Add answer')
                ->collapsible()
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sequence')->label('#')->sortable(),
                TextColumn::make('prompt')->label('Question')->searchable()->limit(90)->wrap(),
                TextColumn::make('type')->badge(),
                TextColumn::make('points'),
                TextColumn::make('options_count')->counts('options')->label('Answers'),
                IconColumn::make('is_active')->label('Active')->boolean(),
            ])
            ->headerActions([CreateAction::make()->label('Add question')])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->reorderable('sequence')
            ->defaultSort('sequence');
    }
}
