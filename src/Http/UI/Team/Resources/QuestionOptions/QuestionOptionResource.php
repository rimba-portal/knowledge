<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QuestionOptions;

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
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionOptions\Pages\CreateQuestionOption;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionOptions\Pages\EditQuestionOption;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionOptions\Pages\ListQuestionOptions;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionOptions\Pages\ViewQuestionOption;
use Rimba\Knowledge\Models\QuestionOption;

class QuestionOptionResource extends Resource
{
    protected static ?string $model = QuestionOption::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $recordTitleAttribute = 'answer';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('question_id')->relationship('question', 'prompt')->required()->searchable()->preload(),
            Textarea::make('answer')->required()->columnSpanFull(),
            Toggle::make('is_correct')->default(false),
            TextInput::make('sequence')->numeric()->minValue(0)->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('question.prompt')->label('Question')->limit(60),
            TextColumn::make('answer')->limit(80)->searchable(),
            IconColumn::make('is_correct')->boolean(),
            TextColumn::make('sequence')->sortable(),
        ])->recordActions([ViewAction::make(), EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionOptions::route('/'),
            'create' => CreateQuestionOption::route('/create'),
            'view' => ViewQuestionOption::route('/{record}'),
            'edit' => EditQuestionOption::route('/{record}/edit'),
        ];
    }
}
