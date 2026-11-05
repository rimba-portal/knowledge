<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rimba\Knowledge\Models\QualificationAttempt;

final class QualificationAttemptCompleted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public readonly QualificationAttempt $attempt) {}
}
