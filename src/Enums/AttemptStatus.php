<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AttemptStatus: string implements HasColor, HasLabel
{
    case InProgress = 'in_progress';
    case Submitted = 'submitted';
    case Abandoned = 'abandoned';

    public function getLabel(): string
    {
        return match ($this) {
            self::InProgress => 'In progress',
            self::Submitted => 'Submitted',
            self::Abandoned => 'Abandoned',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::InProgress => 'warning',
            self::Submitted => 'success',
            self::Abandoned => 'gray',
        };
    }
}
