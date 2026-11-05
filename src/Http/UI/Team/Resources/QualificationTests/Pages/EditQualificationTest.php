<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\Pages;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\QualificationTests\QualificationTestResource;
class EditQualificationTest extends EditRecord
{
    protected static string $resource = QualificationTestResource::class;
    protected function getHeaderActions(): array { return [ViewAction::make(), DeleteAction::make()]; }
}
