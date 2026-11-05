<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationTestMaterials;

use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTestMaterials\Pages\CreateQualificationTestMaterial;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTestMaterials\Pages\EditQualificationTestMaterial;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTestMaterials\Pages\ListQualificationTestMaterials;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTestMaterials\Pages\ViewQualificationTestMaterial;
use Rimba\Knowledge\Models\QualificationTestMaterial;

class QualificationTestMaterialResource extends Resource
{
    protected static ?string $model = QualificationTestMaterial::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('qualification_test_id')->relationship('qualificationTest', 'name')->required()->searchable()->preload(),
            Select::make('document_revision_id')->relationship('documentRevision', 'title')->required()->searchable()->preload(),
            TextInput::make('question_limit')->numeric()->minValue(1),
            TextInput::make('sequence')->numeric()->minValue(0)->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('qualificationTest.code')->label('Test'),
            TextColumn::make('documentRevision.document.code')->label('Document'),
            TextColumn::make('documentRevision.revision_code')->label('Revision'),
            TextColumn::make('question_limit'),
            TextColumn::make('sequence')->sortable(),
        ])->recordActions([ViewAction::make(), EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQualificationTestMaterials::route('/'),
            'create' => CreateQualificationTestMaterial::route('/create'),
            'view' => ViewQualificationTestMaterial::route('/{record}'),
            'edit' => EditQualificationTestMaterial::route('/{record}/edit'),
        ];
    }
}
