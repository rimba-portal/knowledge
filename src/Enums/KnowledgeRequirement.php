<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

enum KnowledgeRequirement: string
{
    case REFERENCE = 'reference';
    case AWARENESS = 'awareness';
    case REQUIRED = 'required';
    case QUALIFYING = 'qualifying';

    public function requiresCompletion(): bool
    {
        return $this !== self::REFERENCE;
    }

    public function requiresAssessment(): bool
    {
        return $this === self::QUALIFYING;
    }
}
