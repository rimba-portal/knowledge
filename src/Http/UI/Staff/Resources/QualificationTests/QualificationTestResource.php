<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\QualificationTests;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Rimba\Knowledge\Http\UI\Staff\Resources\QualificationTests\Pages\ListQualificationTests;
use Rimba\Knowledge\Http\UI\Staff\Resources\QualificationTests\Pages\TakeQualificationTest;
use Rimba\Knowledge\Http\UI\Staff\Resources\QualificationTests\Pages\ViewQualificationTest;
use Rimba\Knowledge\Models\QualificationTest;

class QualificationTestResource extends Resource
{
    protected static ?string $model = QualificationTest::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Qualifications';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')->searchable()->copyable()->weight('semibold'),
            TextColumn::make('name')->label('Qualification')->searchable(),
            TextColumn::make('passing_score')->label('Pass')->suffix('%'),
            TextColumn::make('attempt_limit')->label('Attempts')->placeholder('Unlimited'),
        ])->recordActions([
            Action::make('take')->label('Take test')->icon('heroicon-o-play')->url(fn ($record): string => static::getUrl('take', ['record' => $record])),
            ViewAction::make(),
        ])->defaultSort('code');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Qualification')->schema([
                TextEntry::make('code')->copyable(),
                TextEntry::make('name'),
                TextEntry::make('description')->columnSpanFull()->placeholder('—'),
            ])->columns(2),
            Section::make('Assessment')->schema([
                TextEntry::make('passing_score')->label('Passing score')->suffix('%'),
                TextEntry::make('question_limit')->label('Question limit')->placeholder('All available'),
                TextEntry::make('attempt_limit')->label('Attempt limit')->placeholder('Unlimited'),
                TextEntry::make('validity_days')->label('Validity')->suffix(' days')->placeholder('No expiry'),
            ])->columns(4),
            Section::make('Materials')->schema([
                RepeatableEntry::make('materials')->label('')->schema([
                    TextEntry::make('documentRevision.document.code')->label('Document'),
                    TextEntry::make('documentRevision.title')->label('Title'),
                    TextEntry::make('documentRevision.revision_code')->label('Revision')->badge(),
                    TextEntry::make('question_limit')->label('Questions')->placeholder('Default'),
                ])->columns(4)->columnSpanFull(),
            ]),
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status', 'active')
            ->whereNull('review_required_at')
            ->with(['materials.documentRevision.document']);
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
