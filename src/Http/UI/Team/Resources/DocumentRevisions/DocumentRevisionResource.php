<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions;

use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\Pages\ListDocumentRevisions;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\Pages\ViewDocumentRevision;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\Pages\CreateDocumentRevision;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\Pages\EditDocumentRevision;
use Rimba\Knowledge\Models\DocumentRevision;

class DocumentRevisionResource extends Resource
{
    protected static ?string $model = DocumentRevision::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('document_id')->relationship('document', 'name')->required()->searchable()->preload(),
            TextInput::make('revision_code')->required(),
            TextInput::make('title')->required(),
            Textarea::make('summary')->columnSpanFull(),
            Textarea::make('change_notes')->columnSpanFull(),
            Select::make('status')->options(\Rimba\Knowledge\Enums\RevisionStatus::class)->required(),
            TextInput::make('workflow_id')->label('Pinta workflow UUID'),
            DateTimePicker::make('effective_at'),
            DateTimePicker::make('expires_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('document.code')->label('Document')->searchable(),
            TextColumn::make('revision_code')->searchable(),
            TextColumn::make('title')->searchable(),
            TextColumn::make('status')->badge(),
            TextColumn::make('effective_at')->dateTime(),
        ])->recordActions([
            \Filament\Actions\Action::make('submit')
                ->label('Submit for approval')
                ->icon('heroicon-o-paper-airplane')
                ->requiresConfirmation()
                ->visible(fn ($record): bool => in_array($record->status->value, ['draft', 'rejected'], true))
                ->action(fn ($record) => app(\Rimba\Knowledge\Actions\SubmitDocumentRevisionForApproval::class)->handle($record)),
            \Filament\Actions\Action::make('publish')
                ->label('Make effective')
                ->icon('heroicon-o-check-badge')
                ->requiresConfirmation()
                ->visible(fn ($record): bool => $record->status->value === 'approved')
                ->action(fn ($record) => app(\Rimba\Knowledge\Actions\PublishDocumentRevision::class)->handle($record)),
            ViewAction::make(),
            EditAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocumentRevisions::route('/'),
            'create' => CreateDocumentRevision::route('/create'),
            'view' => ViewDocumentRevision::route('/{record}'),
            'edit' => EditDocumentRevision::route('/{record}/edit'),
        ];
    }
}
