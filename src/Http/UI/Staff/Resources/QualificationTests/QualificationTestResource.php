<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\QualificationTests;

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
use Rimba\Knowledge\Http\UI\Staff\Resources\QualificationTests\Pages\ListQualificationTests;
use Rimba\Knowledge\Http\UI\Staff\Resources\QualificationTests\Pages\ViewQualificationTest;
use Rimba\Knowledge\Http\UI\Staff\Resources\QualificationTests\Pages\TakeQualificationTest;
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

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')->searchable(),
            TextColumn::make('name')->searchable(),
            TextColumn::make('passing_score')->suffix('%'),
            TextColumn::make('attempt_limit'),
        ])->recordActions([
            \Filament\Actions\Action::make('take')
                ->label('Take quiz')
                ->icon('heroicon-o-play')
                ->url(fn ($record): string => static::getUrl('take', ['record' => $record])),
            ViewAction::make(),
        ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('status', 'active')->whereNull('review_required_at');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Infolists\Components\TextEntry::make('code'),
            \Filament\Infolists\Components\TextEntry::make('name'),
            \Filament\Infolists\Components\TextEntry::make('description')->columnSpanFull(),
            \Filament\Infolists\Components\TextEntry::make('passing_score')->suffix('%'),
            \Filament\Infolists\Components\RepeatableEntry::make('materials')->schema([
                \Filament\Infolists\Components\TextEntry::make('documentRevision.document.code')->label('Document'),
                \Filament\Infolists\Components\TextEntry::make('documentRevision.revision_code')->label('Revision'),
                \Filament\Infolists\Components\TextEntry::make('question_limit'),
            ])->columnSpanFull(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQualificationTests::route('/'),
            'take' => TakeQualificationTest::route('/{record}/take'),
            'view' => ViewQualificationTest::route('/{record}'),
        ];
    }
}
