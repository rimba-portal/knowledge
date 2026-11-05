<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\ModuleDocuments;

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
use Rimba\Knowledge\Http\UI\Team\Resources\ModuleDocuments\Pages\ListModuleDocuments;
use Rimba\Knowledge\Http\UI\Team\Resources\ModuleDocuments\Pages\ViewModuleDocument;
use Rimba\Knowledge\Http\UI\Team\Resources\ModuleDocuments\Pages\CreateModuleDocument;
use Rimba\Knowledge\Http\UI\Team\Resources\ModuleDocuments\Pages\EditModuleDocument;
use Rimba\Knowledge\Models\ModuleDocument;

class ModuleDocumentResource extends Resource
{
    protected static ?string $model = ModuleDocument::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('learning_module_id')->relationship('learningModule', 'name')->required()->searchable()->preload(),
            Select::make('document_revision_id')->relationship('documentRevision', 'title')->required()->searchable()->preload(),
            TextInput::make('sequence')->numeric()->minValue(0)->default(0),
            Toggle::make('is_required')->default(true),
            Select::make('completion_rule')->options(['view' => 'View', 'acknowledge' => 'Acknowledge', 'pass_test' => 'Pass test'])->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('learningModule.code')->label('Module'),
            TextColumn::make('documentRevision.document.code')->label('Document'),
            TextColumn::make('documentRevision.revision_code')->label('Revision'),
            TextColumn::make('sequence')->sortable(),
            IconColumn::make('is_required')->boolean(),
        ])->recordActions([ViewAction::make(), EditAction::make(),]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListModuleDocuments::route('/'),
            'create' => CreateModuleDocument::route('/create'),
            'view' => ViewModuleDocument::route('/{record}'),
            'edit' => EditModuleDocument::route('/{record}/edit'),
        ];
    }
}
