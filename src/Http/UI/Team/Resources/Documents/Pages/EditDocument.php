<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\Documents\Pages;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\Documents\DocumentResource;
class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;
    protected function getHeaderActions(): array { return [ViewAction::make(), DeleteAction::make()]; }
}
