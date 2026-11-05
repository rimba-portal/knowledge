<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\DocumentRevisions\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Number;
use Rimba\Knowledge\Enums\RevisionStatus;
use Rimba\Knowledge\Models\DocumentFile;
use Rimba\Knowledge\Models\DocumentRevision;

class FilesRelationManager extends RelationManager
{
    protected static string $relationship = 'files';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('path')
                ->label('File')
                ->disk('local')
                ->directory('knowledge/documents')
                ->required()
                ->downloadable()
                ->openable()
                ->columnSpanFull(),
            TextInput::make('name')
                ->label('Display name')
                ->required()
                ->maxLength(255),
            Select::make('locale')
                ->label('Language')
                ->options([
                    'en' => 'English',
                    'ms' => 'Bahasa Melayu',
                    'zh' => 'Chinese',
                ])
                ->searchable(),
            Toggle::make('is_primary')->label('Primary file')->default(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('File')->searchable()->wrap(),
                TextColumn::make('mime_type')->label('Type')->badge()->placeholder('—'),
                TextColumn::make('size_bytes')
                    ->label('Size')
                    ->formatStateUsing(fn (?int $state): string => $state ? Number::fileSize($state) : '—'),
                TextColumn::make('locale')->label('Language')->placeholder('—'),
                IconColumn::make('is_primary')->label('Primary')->boolean(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Upload file')
                    ->visible(fn (): bool => $this->revisionIsEditable()),
            ])
            ->recordActions([
                Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (DocumentFile $record): string => $record->downloadUrl())
                    ->openUrlInNewTab(),
                EditAction::make()->visible(fn (): bool => $this->revisionIsEditable()),
                DeleteAction::make()->visible(fn (): bool => $this->revisionIsEditable()),
            ]);
    }

    private function revisionIsEditable(): bool
    {
        /** @var DocumentRevision $model */
        $model = $this->getOwnerRecord();

        return in_array($model->status, [RevisionStatus::Draft, RevisionStatus::Rejected], true);
    }
}
