<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Rimba\Knowledge\Models\KnowledgeApplicability;

trait InteractsWithKnowledgeApplicabilities
{
    public function knowledgeApplicabilities(): MorphMany
    {
        return $this->morphMany(KnowledgeApplicability::class, 'knowledge');
    }
}
