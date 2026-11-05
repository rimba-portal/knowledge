<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rimba\Knowledge\Models\DocumentRevision;

final class DocumentRevisionSubmitted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public readonly DocumentRevision $revision) {}
}
