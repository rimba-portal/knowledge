<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Policies;

use App\Models\User;
use Rimba\Knowledge\Models\Document;
use Rimba\Knowledge\Services\KnowledgeAccessibility;

final class DocumentPolicy
{
    public function __construct(private readonly KnowledgeAccessibility $knowledgeAccessibility) {}

    public function before(User $user): ?bool
    {
        return $user->can('knowledge.manage') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('knowledge.view');
    }

    public function view(User $user, Document $document): bool
    {
        return $user->can('knowledge.view')
            && $user->staff !== null
            && $this->knowledgeAccessibility->allows($user->staff, $document);
    }
}
