<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Rimba\Knowledge\Enums\QuestionBankStatus;
use Rimba\Knowledge\Enums\RevisionStatus;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\Pages\EditQuestionBank;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\Pages\ViewQuestionBank;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\RelationManagers\QuestionsRelationManager;
use Rimba\Knowledge\Models\QuestionBank;

class QuestionBankResource extends Resource
{
    protected static ?string $model = QuestionBank::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Question bank')
                ->schema([
                    TextInput::make('name')->required()->maxLength(255),
                    Select::make('status')
                        ->options(QuestionBankStatus::class)
                        ->default(QuestionBankStatus::Draft->value)
                        ->required(),
                    DateTimePicker::make('reviewed_at')->label('Reviewed at'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('documentRevision.document.code')->label('Document'),
                TextColumn::make('documentRevision.revision_code')->label('Revision')->badge(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('status')->badge(),
                TextColumn::make('questions_count')->counts('questions')->label('Questions'),
            ])
            ->recordActions([ViewAction::make(), EditAction::make()]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Question bank')
                ->schema([
                    TextEntry::make('documentRevision.document.code')->label('Document'),
                    TextEntry::make('documentRevision.revision_code')->label('Revision')->badge(),
                    TextEntry::make('name'),
                    TextEntry::make('status')->badge(),
                    TextEntry::make('reviewed_at')->dateTime()->placeholder('—'),
                    TextEntry::make('reviewer.name')->label('Reviewed by')->placeholder('—'),
                ])
                ->columns(3),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            'questions' => QuestionsRelationManager::class,
        ];
    }

    public static function canEdit(Model $record): bool
    {
        return parent::canEdit($record)
            && in_array($record->documentRevision->status, [RevisionStatus::Draft, RevisionStatus::Rejected], true);
    }

    public static function canDelete(Model $record): bool
    {
        return parent::canDelete($record)
            && in_array($record->documentRevision->status, [RevisionStatus::Draft, RevisionStatus::Rejected], true);
    }

    public static function getPages(): array
    {
        return [
            'view' => ViewQuestionBank::route('/{record}'),
            'edit' => EditQuestionBank::route('/{record}/edit'),
        ];
    }
}
