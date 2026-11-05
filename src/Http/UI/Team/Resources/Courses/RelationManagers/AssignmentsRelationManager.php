<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Team\Resources\Courses\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Knowledge\Enums\AssignmentStatus;

class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('staff_id')->relationship('staff', 'name')->searchable()->preload()->required(),
            DateTimePicker::make('assigned_at')->default(now())->required(),
            DateTimePicker::make('due_at'),
            Select::make('status')->options(AssignmentStatus::class)->default(AssignmentStatus::Assigned->value)->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('staff.name')->label('Staff')->searchable(),
            TextColumn::make('status')->badge(),
            TextColumn::make('progress_percentage')->label('Progress')->suffix('%'),
            TextColumn::make('due_at')->label('Due')->date()->placeholder('—'),
            TextColumn::make('completed_at')->label('Completed')->date()->placeholder('—'),
        ])->headerActions([
            CreateAction::make()->label('Assign staff'),
        ])->recordActions([
            EditAction::make(),
            DeleteAction::make(),
        ])->defaultSort('assigned_at', 'desc');
    }
}
