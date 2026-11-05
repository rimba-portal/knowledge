<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\Documents;

use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Number;
use Rimba\Knowledge\Http\UI\Staff\Resources\Documents\Pages\ListDocuments;
use Rimba\Knowledge\Http\UI\Staff\Resources\Documents\Pages\ViewDocument;
use Rimba\Knowledge\Models\Document;
use Rimba\Knowledge\Models\DocumentFile;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')->searchable()->sortable()->copyable()->weight('semibold'),
            TextColumn::make('name')->label('Document')->searchable()->sortable()->description(fn (Document $record): ?string => $record->documentType?->name),
            TextColumn::make('currentRevision.revision_code')->label('Revision')->badge(),
            TextColumn::make('currentRevision.effective_at')->label('Effective')->date()->placeholder('—'),
            TextColumn::make('orgUnit.name')->label('Owner')->toggleable(),
        ])->recordActions([ViewAction::make()])->defaultSort('code');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Document')->schema([
                TextEntry::make('code')->copyable(),
                TextEntry::make('name'),
                TextEntry::make('documentType.name')->label('Type')->placeholder('—'),
                TextEntry::make('orgUnit.name')->label('Owner'),
                TextEntry::make('description')->columnSpanFull()->placeholder('—'),
            ])->columns(2),
            Section::make('Current revision')->schema([
                TextEntry::make('currentRevision.revision_code')->label('Revision')->badge(),
                TextEntry::make('currentRevision.title')->label('Title'),
                TextEntry::make('currentRevision.effective_at')->label('Effective')->dateTime()->placeholder('—'),
                TextEntry::make('currentRevision.expires_at')->label('Expires')->dateTime()->placeholder('—'),
            ])->columns(2),
            Section::make('Files')->schema([
                RepeatableEntry::make('currentRevision.files')
                    ->label('')
                    ->schema([
                        TextEntry::make('name')
                            ->label('File')
                            ->url(fn (DocumentFile $record): string => $record->downloadUrl())
                            ->openUrlInNewTab(),
                        TextEntry::make('mime_type')->label('Type')->badge()->placeholder('—'),
                        TextEntry::make('size_bytes')->label('Size')->formatStateUsing(fn (?int $state): string => $state ? Number::fileSize($state) : '—'),
                        TextEntry::make('locale')->label('Language')->placeholder('—'),
                        IconEntry::make('is_primary')->label('Primary')->boolean(),
                    ])
                    ->columns(5)
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereNotNull('current_revision_id')
            ->where('status', 'active')
            ->with(['documentType', 'orgUnit', 'currentRevision.files']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocuments::route('/'),
            'view' => ViewDocument::route('/{record}'),
        ];
    }
}
