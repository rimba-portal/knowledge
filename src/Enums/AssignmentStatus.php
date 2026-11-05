<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AssignmentStatus: string implements HasColor, HasLabel
{
    case Assigned = 'assigned';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Assigned => 'Assigned',
            self::InProgress => 'In progress',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Assigned => 'info',
            self::InProgress => 'warning',
            self::Completed => 'success',
            self::Cancelled => 'gray',
        };
    }
}
