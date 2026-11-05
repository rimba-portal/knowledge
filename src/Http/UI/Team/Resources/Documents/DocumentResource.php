<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\Documents;

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
use Rimba\Knowledge\Http\UI\Team\Resources\Documents\Pages\ListDocuments;
use Rimba\Knowledge\Http\UI\Team\Resources\Documents\Pages\ViewDocument;
use Rimba\Knowledge\Http\UI\Team\Resources\Documents\Pages\CreateDocument;
use Rimba\Knowledge\Http\UI\Team\Resources\Documents\Pages\EditDocument;
use Rimba\Knowledge\Models\Document;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('code')->required()->unique(ignoreRecord: true),
            TextInput::make('name')->required(),
            Select::make('document_type_id')->relationship('documentType', 'name')->searchable()->preload(),
            Select::make('org_unit_id')->relationship('orgUnit', 'name')->required()->searchable()->preload(),
            Select::make('org_team_id')->relationship('orgTeam', 'name')->searchable()->preload(),
            Textarea::make('description')->columnSpanFull(),
            Select::make('status')->options(\Rimba\Knowledge\Enums\DocumentStatus::class)->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')->searchable(),
            TextColumn::make('name')->searchable(),
            TextColumn::make('orgUnit.name')->label('Owner'),
            TextColumn::make('orgTeam.name')->label('Managing team'),
            TextColumn::make('status')->badge(),
        ])->recordActions([ViewAction::make(), EditAction::make(),]);
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
