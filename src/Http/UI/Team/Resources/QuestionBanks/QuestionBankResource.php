<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks;

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
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\Pages\ListQuestionBanks;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\Pages\ViewQuestionBank;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\Pages\CreateQuestionBank;
use Rimba\Knowledge\Http\UI\Team\Resources\QuestionBanks\Pages\EditQuestionBank;
use Rimba\Knowledge\Models\QuestionBank;

class QuestionBankResource extends Resource
{
    protected static ?string $model = QuestionBank::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Knowledge';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('document_revision_id')->relationship('documentRevision', 'title')->required()->searchable()->preload(),
            TextInput::make('name')->required(),
            Select::make('status')->options(\Rimba\Knowledge\Enums\QuestionBankStatus::class)->required(),
            DateTimePicker::make('reviewed_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('documentRevision.document.code')->label('Document'),
            TextColumn::make('documentRevision.revision_code')->label('Revision'),
            TextColumn::make('name')->searchable(),
            TextColumn::make('status')->badge(),
            TextColumn::make('questions_count')->counts('questions')->label('Questions'),
        ])->recordActions([ViewAction::make(), EditAction::make(),]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionBanks::route('/'),
            'create' => CreateQuestionBank::route('/create'),
            'view' => ViewQuestionBank::route('/{record}'),
            'edit' => EditQuestionBank::route('/{record}/edit'),
        ];
    }
}
