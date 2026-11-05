<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

enum RevisionStatus: string
{
    case Draft = 'draft';
    case PendingApproval = 'pending_approval';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Effective = 'effective';
    case Superseded = 'superseded';
    case Withdrawn = 'withdrawn';
}
