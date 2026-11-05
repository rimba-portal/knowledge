<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentTypes;

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
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentTypes\Pages\ListDocumentTypes;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentTypes\Pages\ViewDocumentType;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentTypes\Pages\CreateDocumentType;
use Rimba\Knowledge\Http\UI\Team\Resources\DocumentTypes\Pages\EditDocumentType;
use Rimba\Knowledge\Models\DocumentType;

class DocumentTypeResource extends Resource
{
    protected static ?string $model = DocumentType::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('code')->required()->unique(ignoreRecord: true),
            TextInput::make('name')->required(),
            Textarea::make('description')->columnSpanFull(),
            Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')->searchable(),
            TextColumn::make('name')->searchable(),
            IconColumn::make('is_active')->boolean(),
        ])->recordActions([ViewAction::make(), EditAction::make(),]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocumentTypes::route('/'),
            'create' => CreateDocumentType::route('/create'),
            'view' => ViewDocumentType::route('/{record}'),
            'edit' => EditDocumentType::route('/{record}/edit'),
        ];
    }
}
