<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum QuestionBankStatus: string implements HasColor, HasLabel
{
    case Draft = 'draft';
    case ReviewRequired = 'review_required';
    case Active = 'active';
    case Archived = 'archived';

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::ReviewRequired => 'Review required',
            self::Active => 'Active',
            self::Archived => 'Archived',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Draft, self::Archived => 'gray',
            self::ReviewRequired => 'warning',
            self::Active => 'success',
        };
    }
}
