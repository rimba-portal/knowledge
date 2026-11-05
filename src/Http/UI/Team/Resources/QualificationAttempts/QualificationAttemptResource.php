<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationAttempts;

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
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationAttempts\Pages\ListQualificationAttempts;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationAttempts\Pages\ViewQualificationAttempt;
use Rimba\Knowledge\Models\QualificationAttempt;

class QualificationAttemptResource extends Resource
{
    protected static ?string $model = QualificationAttempt::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('qualificationTest.code')->label('Test'),
            TextColumn::make('staff_uuid')->label('Staff UUID')->searchable(),
            TextColumn::make('score')->suffix('%'),
            IconColumn::make('passed')->boolean(),
            TextColumn::make('submitted_at')->dateTime(),
        ])->recordActions([ViewAction::make(),]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQualificationAttempts::route('/'),
            'view' => ViewQualificationAttempt::route('/{record}'),
        ];
    }
}
