<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

enum AttemptStatus: string
{
    case InProgress = 'in_progress';
    case Submitted = 'submitted';
    case Abandoned = 'abandoned';
}
