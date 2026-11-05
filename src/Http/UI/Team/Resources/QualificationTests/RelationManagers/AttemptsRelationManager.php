<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\RelationManagers;

use Filament\Actions\Action;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationAttempts\QualificationAttemptResource;
use Rimba\Knowledge\Models\QualificationAttempt;

class AttemptsRelationManager extends RelationManager
{
    protected static string $relationship = 'attempts';

    protected static ?string $title = 'Attempts';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('staff.name')->label('Staff')->searchable(),
            TextColumn::make('status')->badge(),
            TextColumn::make('score')->suffix('%')->placeholder('—'),
            IconColumn::make('passed')->boolean(),
            TextColumn::make('submitted_at')->label('Submitted')->dateTime()->placeholder('—'),
        ])->recordActions([
            Action::make('view')
                ->icon('heroicon-o-eye')
                ->url(fn (QualificationAttempt $record): string => QualificationAttemptResource::getUrl('view', ['record' => $record])),
        ])->defaultSort('created_at', 'desc');
    }
}
