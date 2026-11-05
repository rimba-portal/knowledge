<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationAttempts\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnswersRelationManager extends RelationManager
{
    protected static string $relationship = 'answers';

    protected static ?string $title = 'Answers';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('sequence')->label('#'),
            TextColumn::make('question_text')->label('Question')->wrap()->limit(100),
            TextColumn::make('question_type')->label('Type')->badge(),
            TextColumn::make('earned_points')->label('Earned'),
            TextColumn::make('points')->label('Available'),
            IconColumn::make('is_correct')->label('Correct')->boolean()->placeholder('—'),
        ])->defaultSort('sequence');
    }
}
