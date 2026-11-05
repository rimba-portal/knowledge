<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules;

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
use Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules\Pages\ListLearningModules;
use Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules\Pages\ViewLearningModule;
use Rimba\Knowledge\Models\LearningModule;

class LearningModuleResource extends Resource
{
    protected static ?string $model = LearningModule::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Learning';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')->searchable()->copyable()->weight('semibold'),
            TextColumn::make('name')->label('Learning module')->searchable(),
            TextColumn::make('estimated_minutes')->label('Duration')->suffix(' min')->placeholder('—'),
            TextColumn::make('module_documents_count')->counts('moduleDocuments')->label('Materials'),
        ])->recordActions([ViewAction::make()])->defaultSort('code');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Learning module')->schema([
                TextEntry::make('code')->copyable(),
                TextEntry::make('name'),
                TextEntry::make('estimated_minutes')->label('Estimated duration')->suffix(' minutes')->placeholder('—'),
                TextEntry::make('description')->columnSpanFull()->placeholder('—'),
            ])->columns(2),
            Section::make('Learning materials')->schema([
                RepeatableEntry::make('moduleDocuments')->label('')->schema([
                    TextEntry::make('sequence')->label('#'),
                    TextEntry::make('documentRevision.document.code')->label('Document'),
                    TextEntry::make('documentRevision.title')->label('Title'),
                    TextEntry::make('documentRevision.revision_code')->label('Revision')->badge(),
                    TextEntry::make('completion_rule')->label('Completion')->badge(),
                    IconEntry::make('is_required')->label('Required')->boolean(),
                ])->columns(6)->columnSpanFull(),
            ]),
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', 'active')->with(['moduleDocuments.documentRevision.document']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLearningModules::route('/'),
            'view' => ViewLearningModule::route('/{record}'),
        ];
    }
}
