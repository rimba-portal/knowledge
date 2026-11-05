<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Rimba\Knowledge\Enums\RevisionStatus;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\Pages\EditDocumentRevision;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\Pages\ViewDocumentRevision;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\RelationManagers\FilesRelationManager;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\RelationManagers\QuestionBanksRelationManager;
use Rimba\Knowledge\Models\DocumentRevision;

class DocumentRevisionResource extends Resource
{
    protected static ?string $model = DocumentRevision::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Revision')
                ->schema([
                    TextInput::make('revision_code')
                        ->label('Revision')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Textarea::make('summary')
                        ->rows(3)
                        ->columnSpanFull(),
                    Textarea::make('change_notes')
                        ->label('Change notes')
                        ->rows(5)
                        ->columnSpanFull(),
                ])
                ->columns(2),
            Section::make('Lifecycle')
                ->schema([
                    Select::make('status')
                        ->options(RevisionStatus::class)
                        ->disabled()
                        ->dehydrated(false),
                    DateTimePicker::make('effective_at')->label('Effective at'),
                    DateTimePicker::make('expires_at')->label('Expires at'),
                ])
                ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document.code')->label('Document')->searchable(),
                TextColumn::make('revision_code')->label('Rev')->badge()->sortable(),
                TextColumn::make('title')->searchable(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('effective_at')->label('Effective')->date()->placeholder('—'),
                TextColumn::make('files_count')->counts('files')->label('Files'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Revision')
                ->schema([
                    TextEntry::make('document.code')->label('Document')->copyable(),
                    TextEntry::make('revision_code')->label('Revision')->badge(),
                    TextEntry::make('title'),
                    TextEntry::make('status')->badge(),
                    TextEntry::make('summary')->columnSpanFull()->placeholder('—'),
                    TextEntry::make('change_notes')->label('Change notes')->columnSpanFull()->placeholder('—'),
                ])
                ->columns(2),
            Section::make('Lifecycle')
                ->schema([
                    TextEntry::make('submitted_at')->dateTime()->placeholder('—'),
                    TextEntry::make('approved_at')->dateTime()->placeholder('—'),
                    TextEntry::make('approver.name')->label('Approved by')->placeholder('—'),
                    TextEntry::make('issued_at')->dateTime()->placeholder('—'),
                    TextEntry::make('effective_at')->dateTime()->placeholder('—'),
                    TextEntry::make('expires_at')->dateTime()->placeholder('—'),
                ])
                ->columns(3),
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['document', 'approver', 'publisher']);
    }

    public static function getRelations(): array
    {
        return [
            'files' => FilesRelationManager::class,
            'question-banks' => QuestionBanksRelationManager::class,
        ];
    }

    public static function canEdit(Model $record): bool
    {
        return parent::canEdit($record)
            && in_array($record->status, [RevisionStatus::Draft, RevisionStatus::Rejected], true);
    }

    public static function canDelete(Model $record): bool
    {
        return parent::canDelete($record)
            && in_array($record->status, [RevisionStatus::Draft, RevisionStatus::Rejected], true);
    }

    public static function getPages(): array
    {
        return [
            'view' => ViewDocumentRevision::route('/{record}'),
            'edit' => EditDocumentRevision::route('/{record}/edit'),
        ];
    }
}
