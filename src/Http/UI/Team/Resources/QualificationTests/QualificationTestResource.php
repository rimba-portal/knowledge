<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests;

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
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\Pages\CreateQualificationTest;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\Pages\EditQualificationTest;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\Pages\ListQualificationTests;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\Pages\ViewQualificationTest;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\RelationManagers\AttemptsRelationManager;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\RelationManagers\MaterialsRelationManager;
use Rimba\Knowledge\Models\QualificationTest;

class QualificationTestResource extends Resource
{
    protected static ?string $model = QualificationTest::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Qualification test')->schema([
                TextInput::make('code')->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('name')->required()->maxLength(255),
                Textarea::make('description')->rows(4)->columnSpanFull(),
                TextInput::make('job_role_uuid')->label('MES job-role UUID')->uuid(),
            ])->columns(2),
            Section::make('Assessment settings')->schema([
                TextInput::make('passing_score')->numeric()->minValue(0)->maxValue(100)->suffix('%')->required(),
                TextInput::make('question_limit')->numeric()->minValue(1),
                TextInput::make('attempt_limit')->numeric()->minValue(1),
                TextInput::make('validity_days')->numeric()->minValue(1)->suffix('days'),
            ])->columns(4),
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
            TextColumn::make('name')->label('Qualification test')->searchable()->sortable(),
            TextColumn::make('passing_score')->label('Pass')->suffix('%'),
            TextColumn::make('materials_count')->counts('materials')->label('Materials'),
            TextColumn::make('status')->badge()->sortable(),
            TextColumn::make('review_required_at')->label('Review due')->date()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ])->recordActions([ViewAction::make(), EditAction::make()])->defaultSort('code');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Qualification test')->schema([
                TextEntry::make('code')->copyable(),
                TextEntry::make('name'),
                TextEntry::make('status')->badge(),
                TextEntry::make('orgUnit.name')->label('Owning unit'),
                TextEntry::make('description')->columnSpanFull()->placeholder('—'),
            ])->columns(2),
            Section::make('Assessment settings')->schema([
                TextEntry::make('passing_score')->label('Passing score')->suffix('%'),
                TextEntry::make('question_limit')->label('Question limit')->placeholder('All available'),
                TextEntry::make('attempt_limit')->label('Attempt limit')->placeholder('Unlimited'),
                TextEntry::make('validity_days')->label('Validity')->suffix(' days')->placeholder('No expiry'),
            ])->columns(4),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            'materials' => MaterialsRelationManager::class,
            'attempts' => AttemptsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQualificationTests::route('/'),
            'create' => CreateQualificationTest::route('/create'),
            'view' => ViewQualificationTest::route('/{record}'),
            'edit' => EditQualificationTest::route('/{record}/edit'),
        ];
    }
}
