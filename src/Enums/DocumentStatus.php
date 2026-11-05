<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

enum DocumentStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Retired = 'retired';
    case Archived = 'archived';
}
