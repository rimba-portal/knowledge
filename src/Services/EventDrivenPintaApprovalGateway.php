<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Services;

use Rimba\Knowledge\Contracts\DocumentRevisionApprovalGateway;
use Rimba\Knowledge\Events\DocumentRevisionSubmitted;
use Rimba\Knowledge\Models\DocumentRevision;

final class EventDrivenPintaApprovalGateway implements DocumentRevisionApprovalGateway
{
    public function submit(DocumentRevision $revision): ?string
    {
        DocumentRevisionSubmitted::dispatch($revision);

        return null;
    }
}
