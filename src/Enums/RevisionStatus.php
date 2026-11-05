<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RevisionStatus: string implements HasColor, HasLabel
{
    case Draft = 'draft';
    case PendingApproval = 'pending_approval';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Effective = 'effective';
    case Superseded = 'superseded';
    case Withdrawn = 'withdrawn';

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::PendingApproval => 'Pending approval',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::Effective => 'Effective',
            self::Superseded => 'Superseded',
            self::Withdrawn => 'Withdrawn',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Draft, self::Superseded, self::Withdrawn => 'gray',
            self::PendingApproval => 'warning',
            self::Approved => 'info',
            self::Rejected => 'danger',
            self::Effective => 'success',
        };
    }
}
