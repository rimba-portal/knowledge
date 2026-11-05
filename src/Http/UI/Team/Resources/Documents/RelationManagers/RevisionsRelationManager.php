<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\Documents\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Actions\PublishDocumentRevision;
use Rimba\Knowledge\Actions\SubmitDocumentRevisionForApproval;
use Rimba\Knowledge\Enums\RevisionStatus;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\DocumentRevisionResource;
use Rimba\Knowledge\Models\DocumentRevision;

class RevisionsRelationManager extends RelationManager
{
    protected static string $relationship = 'revisions';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $title = 'Revisions';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('revision_code')->label('Revision')->required()->maxLength(255),
            TextInput::make('title')->required()->maxLength(255),
            Textarea::make('summary')->rows(3)->columnSpanFull(),
            Textarea::make('change_notes')->label('Change notes')->rows(4)->columnSpanFull(),
            DateTimePicker::make('effective_at')->label('Planned effective date'),
            DateTimePicker::make('expires_at')->label('Expiry date'),
            Hidden::make('status')->default(RevisionStatus::Draft->value),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('revision_code')->label('Rev')->badge()->sortable(),
                TextColumn::make('title')->searchable()->wrap(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('effective_at')->label('Effective')->date()->placeholder('—'),
                TextColumn::make('files_count')->counts('files')->label('Files'),
            ])
            ->headerActions([
                CreateAction::make()->label('New revision'),
            ])
            ->recordActions([
                Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->url(fn (DocumentRevision $record): string => DocumentRevisionResource::getUrl('view', ['record' => $record])),
                Action::make('edit')
                    ->icon('heroicon-o-pencil-square')
                    ->visible(fn (DocumentRevision $record): bool => in_array($record->status, [RevisionStatus::Draft, RevisionStatus::Rejected], true))
                    ->url(fn (DocumentRevision $record): string => DocumentRevisionResource::getUrl('edit', ['record' => $record])),
                Action::make('submit')
                    ->label('Submit')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (DocumentRevision $record): bool => in_array($record->status, [RevisionStatus::Draft, RevisionStatus::Rejected], true))
                    ->action(fn (DocumentRevision $record) => app(SubmitDocumentRevisionForApproval::class)->handle($record)),
                Action::make('publish')
                    ->label('Make effective')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (DocumentRevision $record): bool => $record->status === RevisionStatus::Approved)
                    ->action(fn (DocumentRevision $record) => app(PublishDocumentRevision::class)->handle($record)),
                DeleteAction::make()
                    ->visible(fn (DocumentRevision $record): bool => in_array($record->status, [RevisionStatus::Draft, RevisionStatus::Rejected], true)),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
