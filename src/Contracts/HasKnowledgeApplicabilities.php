<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasKnowledgeApplicabilities
{
    public function knowledgeApplicabilities(): MorphMany;
}
