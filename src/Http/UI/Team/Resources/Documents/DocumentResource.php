<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\Documents;

use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Rimba\Knowledge\Enums\DocumentStatus;
use Rimba\Knowledge\Http\UI\Team\Resources\Documents\Pages\CreateDocument;
use Rimba\Knowledge\Http\UI\Team\Resources\Documents\Pages\EditDocument;
use Rimba\Knowledge\Http\UI\Team\Resources\Documents\Pages\ListDocuments;
use Rimba\Knowledge\Http\UI\Team\Resources\Documents\Pages\ViewDocument;
use Rimba\Knowledge\Http\UI\Team\Resources\Documents\RelationManagers\LinksRelationManager;
use Rimba\Knowledge\Http\UI\Team\Resources\Documents\RelationManagers\RevisionsRelationManager;
use Rimba\Knowledge\Models\Document;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Document')
                ->description('Identity and purpose of the controlled document.')
                ->schema([
                    TextInput::make('code')
                        ->label('Code')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    Select::make('document_type_id')
                        ->label('Type')
                        ->relationship('documentType', 'name')
                        ->searchable()
                        ->preload(),
                    TextInput::make('name')
                        ->label('Document name')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Textarea::make('description')
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->columns(2),
            Section::make('Ownership')
                ->description('Accountability and lifecycle state.')
                ->schema([
                    Select::make('org_unit_id')
                        ->label('Owning unit')
                        ->relationship('orgUnit', 'name')
                        ->required()
                        ->searchable()
                        ->preload(),
                    Select::make('org_team_id')
                        ->label('Managing team')
                        ->relationship('orgTeam', 'name')
                        ->searchable()
                        ->preload(),
                    Select::make('status')
                        ->options(DocumentStatus::class)
                        ->default(DocumentStatus::Draft->value)
                        ->required(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('semibold'),
                TextColumn::make('name')
                    ->label('Document')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Document $record): ?string => $record->documentType?->name),
                TextColumn::make('currentRevision.revision_code')
                    ->label('Revision')
                    ->badge()
                    ->placeholder('—'),
                TextColumn::make('orgUnit.name')
                    ->label('Owner')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('orgTeam.name')
                    ->label('Managing team')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->defaultSort('code');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Document')
                ->schema([
                    TextEntry::make('code')->label('Code')->copyable(),
                    TextEntry::make('name')->label('Document'),
                    TextEntry::make('documentType.name')->label('Type')->placeholder('—'),
                    TextEntry::make('status')->badge(),
                    TextEntry::make('description')->columnSpanFull()->placeholder('—'),
                ])
                ->columns(2),
            Section::make('Ownership')
                ->schema([
                    TextEntry::make('orgUnit.name')->label('Owning unit'),
                    TextEntry::make('orgTeam.name')->label('Managing team')->placeholder('—'),
                ])
                ->columns(2),
            Section::make('Current revision')
                ->schema([
                    TextEntry::make('currentRevision.revision_code')->label('Revision')->badge()->placeholder('—'),
                    TextEntry::make('currentRevision.title')->label('Title')->placeholder('—'),
                    TextEntry::make('currentRevision.status')->label('Status')->badge()->placeholder('—'),
                    TextEntry::make('currentRevision.effective_at')->label('Effective')->dateTime()->placeholder('—'),
                    TextEntry::make('currentRevision.approved_at')->label('Approved')->dateTime()->placeholder('—'),
                    TextEntry::make('currentRevision.expires_at')->label('Expires')->dateTime()->placeholder('—'),
                ])
                ->columns(3),
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with([
            'documentType',
            'orgUnit',
            'orgTeam',
            'currentRevision',
        ]);
    }

    public static function getRelations(): array
    {
        return [
            'revisions' => RevisionsRelationManager::class,
            'links' => LinksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocuments::route('/'),
            'create' => CreateDocument::route('/create'),
            'view' => ViewDocument::route('/{record}'),
            'edit' => EditDocument::route('/{record}/edit'),
        ];
    }
}
