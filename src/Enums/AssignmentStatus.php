<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

enum AssignmentStatus: string
{
    case Assigned = 'assigned';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
