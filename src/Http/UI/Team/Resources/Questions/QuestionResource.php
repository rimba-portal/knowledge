<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\Questions;

use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
use Rimba\Knowledge\Enums\QuestionType;
use Rimba\Knowledge\Http\UI\Team\Resources\Questions\Pages\CreateQuestion;
use Rimba\Knowledge\Http\UI\Team\Resources\Questions\Pages\EditQuestion;
use Rimba\Knowledge\Http\UI\Team\Resources\Questions\Pages\ListQuestions;
use Rimba\Knowledge\Http\UI\Team\Resources\Questions\Pages\ViewQuestion;
use Rimba\Knowledge\Models\Question;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $recordTitleAttribute = 'prompt';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('question_bank_id')->relationship('questionBank', 'name')->required()->searchable()->preload(),
            Select::make('type')->options(QuestionType::class)->required(),
            Textarea::make('prompt')->required()->columnSpanFull(),
            Textarea::make('explanation')->columnSpanFull(),
            TextInput::make('points')->numeric()->minValue(0.01)->default(1)->required(),
            TextInput::make('sequence')->numeric()->minValue(0)->default(0),
            Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('questionBank.name')->label('Bank'),
            TextColumn::make('prompt')->limit(80)->searchable(),
            TextColumn::make('type')->badge(),
            TextColumn::make('points'),
            TextColumn::make('options_count')->counts('options')->label('Options'),
            IconColumn::make('is_active')->boolean(),
        ])->recordActions([ViewAction::make(), EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestions::route('/'),
            'create' => CreateQuestion::route('/create'),
            'view' => ViewQuestion::route('/{record}'),
            'edit' => EditQuestion::route('/{record}/edit'),
        ];
    }
}
