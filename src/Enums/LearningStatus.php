<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum LearningStatus: string implements HasColor, HasLabel
{
    case Draft = 'draft';
    case Active = 'active';
    case Retired = 'retired';
    case ReviewRequired = 'review_required';

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Active => 'Active',
            self::Retired => 'Retired',
            self::ReviewRequired => 'Review required',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Active => 'success',
            self::Retired => 'gray',
            self::ReviewRequired => 'warning',
        };
    }
}
