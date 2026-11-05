<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\LearningModules;

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
use Rimba\Knowledge\Enums\LearningStatus;
use Rimba\Knowledge\Http\UI\Team\Resources\LearningModules\Pages\CreateLearningModule;
use Rimba\Knowledge\Http\UI\Team\Resources\LearningModules\Pages\EditLearningModule;
use Rimba\Knowledge\Http\UI\Team\Resources\LearningModules\Pages\ListLearningModules;
use Rimba\Knowledge\Http\UI\Team\Resources\LearningModules\Pages\ViewLearningModule;
use Rimba\Knowledge\Http\UI\Team\Resources\LearningModules\RelationManagers\MaterialsRelationManager;
use Rimba\Knowledge\Models\LearningModule;

class LearningModuleResource extends Resource
{
    protected static ?string $model = LearningModule::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Learning module')->schema([
                TextInput::make('code')->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('name')->required()->maxLength(255),
                Textarea::make('description')->rows(4)->columnSpanFull(),
                TextInput::make('estimated_minutes')->label('Estimated duration')->numeric()->minValue(0)->suffix('minutes'),
            ])->columns(2),
            Section::make('Ownership')->schema([
                Select::make('org_unit_id')->label('Owning unit')->relationship('orgUnit', 'name')->required()->searchable()->preload(),
                Select::make('org_team_id')->label('Managing team')->relationship('orgTeam', 'name')->searchable()->preload(),
                Select::make('status')->options(LearningStatus::class)->default(LearningStatus::Draft->value)->required(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')->searchable()->sortable()->copyable()->weight('semibold'),
            TextColumn::make('name')->label('Learning module')->searchable()->sortable(),
            TextColumn::make('module_documents_count')->counts('moduleDocuments')->label('Materials'),
            TextColumn::make('estimated_minutes')->label('Duration')->suffix(' min')->placeholder('—'),
            TextColumn::make('status')->badge()->sortable(),
        ])->recordActions([ViewAction::make(), EditAction::make()])->defaultSort('code');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Learning module')->schema([
                TextEntry::make('code')->copyable(),
                TextEntry::make('name'),
                TextEntry::make('status')->badge(),
                TextEntry::make('estimated_minutes')->label('Estimated duration')->suffix(' minutes')->placeholder('—'),
                TextEntry::make('orgUnit.name')->label('Owning unit'),
                TextEntry::make('orgTeam.name')->label('Managing team')->placeholder('—'),
                TextEntry::make('description')->columnSpanFull()->placeholder('—'),
            ])->columns(2),
        ]);
    }

    public static function getRelations(): array
    {
        return ['materials' => MaterialsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLearningModules::route('/'),
            'create' => CreateLearningModule::route('/create'),
            'view' => ViewLearningModule::route('/{record}'),
            'edit' => EditLearningModule::route('/{record}/edit'),
        ];
    }
}
