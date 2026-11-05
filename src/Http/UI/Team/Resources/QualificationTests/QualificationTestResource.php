<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests;

use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Enums\LearningStatus;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\Pages\CreateQualificationTest;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\Pages\EditQualificationTest;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\Pages\ListQualificationTests;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\Pages\ViewQualificationTest;
use Rimba\Knowledge\Models\QualificationTest;

class QualificationTestResource extends Resource
{
    protected static ?string $model = QualificationTest::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('code')->required()->unique(ignoreRecord: true),
            TextInput::make('name')->required(),
            Textarea::make('description')->columnSpanFull(),
            Select::make('org_unit_id')->relationship('orgUnit', 'name')->required()->searchable()->preload(),
            Select::make('org_team_id')->relationship('orgTeam', 'name')->searchable()->preload(),
            TextInput::make('job_role_uuid')->label('MES job-role UUID'),
            TextInput::make('passing_score')->numeric()->minValue(0)->maxValue(100)->required(),
            TextInput::make('question_limit')->numeric()->minValue(1),
            TextInput::make('attempt_limit')->numeric()->minValue(1),
            TextInput::make('validity_days')->numeric()->minValue(1),
            Select::make('status')->options(LearningStatus::class)->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')->searchable(),
            TextColumn::make('name')->searchable(),
            TextColumn::make('passing_score')->suffix('%'),
            TextColumn::make('status')->badge(),
            TextColumn::make('review_required_at')->dateTime(),
        ])->recordActions([ViewAction::make(), EditAction::make()]);
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
