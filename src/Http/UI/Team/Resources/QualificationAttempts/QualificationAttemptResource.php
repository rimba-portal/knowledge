<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationAttempts;

use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationAttempts\Pages\ListQualificationAttempts;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationAttempts\Pages\ViewQualificationAttempt;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationAttempts\RelationManagers\AnswersRelationManager;
use Rimba\Knowledge\Models\QualificationAttempt;

class QualificationAttemptResource extends Resource
{
    protected static ?string $model = QualificationAttempt::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTrophy;

    protected static ?string $navigationLabel = 'Qualification results';

    protected static ?string $modelLabel = 'qualification result';

    protected static ?string $pluralModelLabel = 'qualification results';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?int $navigationSort = 60;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('qualificationTest.code')->label('Test')->searchable(),
            TextColumn::make('staff.name')->label('Staff')->searchable(),
            TextColumn::make('status')->badge(),
            TextColumn::make('score')->suffix('%')->placeholder('—'),
            IconColumn::make('passed')->boolean(),
            TextColumn::make('submitted_at')->label('Submitted')->dateTime()->placeholder('—'),
            TextColumn::make('staff_uuid')->label('Staff UUID')->copyable()->toggleable(isToggledHiddenByDefault: true),
        ])->recordActions([ViewAction::make()])->defaultSort('created_at', 'desc');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Result')->schema([
                TextEntry::make('qualificationTest.code')->label('Test'),
                TextEntry::make('qualificationTest.name')->label('Qualification'),
                TextEntry::make('staff.name')->label('Staff'),
                TextEntry::make('status')->badge(),
                TextEntry::make('score')->suffix('%')->placeholder('—'),
                IconEntry::make('passed')->boolean(),
                TextEntry::make('earned_points')->label('Earned points'),
                TextEntry::make('total_points')->label('Total points'),
                TextEntry::make('started_at')->dateTime()->placeholder('—'),
                TextEntry::make('submitted_at')->dateTime()->placeholder('—'),
                TextEntry::make('expires_at')->dateTime()->placeholder('—'),
            ])->columns(3),
        ]);
    }

    public static function getRelations(): array
    {
        return ['answers' => AnswersRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQualificationAttempts::route('/'),
            'view' => ViewQualificationAttempt::route('/{record}'),
        ];
    }
}
