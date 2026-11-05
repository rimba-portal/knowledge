<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

enum LearningStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Retired = 'retired';
    case ReviewRequired = 'review_required';
}
