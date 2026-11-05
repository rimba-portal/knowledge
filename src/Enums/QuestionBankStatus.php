<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

enum QuestionBankStatus: string
{
    case Draft = 'draft';
    case ReviewRequired = 'review_required';
    case Active = 'active';
    case Archived = 'archived';
}
