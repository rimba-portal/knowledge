<?php

declare(strict_types=1);
namespace Rimba\Knowledge\Http\UI\Team\Resources\Questions\Pages;
use Filament\Resources\Pages\CreateRecord;
use Rimba\Knowledge\Http\UI\Team\Resources\Questions\QuestionResource;
class CreateQuestion extends CreateRecord { protected static string $resource = QuestionResource::class; }
