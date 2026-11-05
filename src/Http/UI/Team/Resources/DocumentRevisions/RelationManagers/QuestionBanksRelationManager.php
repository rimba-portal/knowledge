<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Enums\QuestionBankStatus;
use Rimba\Knowledge\Enums\RevisionStatus;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\QuestionBankResource;
use Rimba\Knowledge\Models\DocumentRevision;
use Rimba\Knowledge\Models\QuestionBank;

class QuestionBanksRelationManager extends RelationManager
{
    protected static string $relationship = 'questionBanks';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Question banks';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(255),
            Select::make('status')
                ->options(QuestionBankStatus::class)
                ->default(QuestionBankStatus::Draft->value)
                ->required(),
            DateTimePicker::make('reviewed_at')->label('Reviewed at'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('status')->badge(),
                TextColumn::make('questions_count')->counts('questions')->label('Questions'),
                TextColumn::make('reviewed_at')->date()->placeholder('—'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->visible(fn (): bool => $this->revisionIsEditable()),
            ])
            ->recordActions([
                Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->url(fn (QuestionBank $record): string => QuestionBankResource::getUrl('view', ['record' => $record])),
                EditAction::make()->visible(fn (): bool => $this->revisionIsEditable()),
                DeleteAction::make()->visible(fn (): bool => $this->revisionIsEditable()),
            ]);
    }

    private function revisionIsEditable(): bool
    {
        /** @var DocumentRevision $model */
        $model = $this->getOwnerRecord();

        return in_array($model->status, [RevisionStatus::Draft, RevisionStatus::Rejected], true);
    }
}
