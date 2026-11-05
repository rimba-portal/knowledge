<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\Documents;

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
use Rimba\Knowledge\Http\UI\Staff\Resources\Documents\Pages\ListDocuments;
use Rimba\Knowledge\Http\UI\Staff\Resources\Documents\Pages\ViewDocument;
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

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')->searchable(),
            TextColumn::make('name')->searchable(),
            TextColumn::make('currentRevision.revision_code')->label('Revision'),
            TextColumn::make('currentRevision.effective_at')->label('Effective')->date(),
        ])->recordActions([ViewAction::make(),]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->whereNotNull('current_revision_id')->where('status', 'active');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Infolists\Components\TextEntry::make('code'),
            \Filament\Infolists\Components\TextEntry::make('name'),
            \Filament\Infolists\Components\TextEntry::make('description')->columnSpanFull(),
            \Filament\Infolists\Components\TextEntry::make('currentRevision.revision_code')->label('Effective revision'),
            \Filament\Infolists\Components\TextEntry::make('currentRevision.effective_at')->dateTime(),
            \Filament\Infolists\Components\RepeatableEntry::make('currentRevision.files')->schema([
                \Filament\Infolists\Components\TextEntry::make('name'),
                \Filament\Infolists\Components\TextEntry::make('path'),
                \Filament\Infolists\Components\TextEntry::make('mime_type'),
            ])->columnSpanFull(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocuments::route('/'),
            'view' => ViewDocument::route('/{record}'),
        ];
    }
}
