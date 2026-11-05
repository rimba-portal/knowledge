<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentFiles;

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
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentFiles\Pages\ListDocumentFiles;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentFiles\Pages\ViewDocumentFile;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentFiles\Pages\CreateDocumentFile;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentFiles\Pages\EditDocumentFile;
use Rimba\Knowledge\Models\DocumentFile;

class DocumentFileResource extends Resource
{
    protected static ?string $model = DocumentFile::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('document_revision_id')->relationship('revision', 'title')->required()->searchable()->preload(),
            \Filament\Forms\Components\FileUpload::make('path')->disk('local')->directory('knowledge/documents')->required(),
            TextInput::make('name')->required(),
            TextInput::make('mime_type'),
            TextInput::make('checksum_sha256')->length(64),
            TextInput::make('locale')->maxLength(12),
            Toggle::make('is_primary')->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('revision.document.code')->label('Document'),
            TextColumn::make('revision.revision_code')->label('Revision'),
            TextColumn::make('name')->searchable(),
            TextColumn::make('mime_type'),
            IconColumn::make('is_primary')->boolean(),
        ])->recordActions([ViewAction::make(), EditAction::make(),]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocumentFiles::route('/'),
            'create' => CreateDocumentFile::route('/create'),
            'view' => ViewDocumentFile::route('/{record}'),
            'edit' => EditDocumentFile::route('/{record}/edit'),
        ];
    }
}
