<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Services;

use Illuminate\Database\Eloquent\Model;
use Rimba\Knowledge\Contracts\HasKnowledgeApplicabilities;
use Rimba\Mesa\ResourceManagement\Models\Staff;

final class KnowledgeAccessibility
{
    public function allows(Staff $staff, HasKnowledgeApplicabilities $knowledge): bool
    {
        $assignments = $staff->jobRoleAssignments()
            ->currentlyEffective()
            ->with(['jobRole', 'scope'])
            ->get();

        $rules = $knowledge->knowledgeApplicabilities()
            ->currentlyEffective()
            ->with(['jobRole', 'scope'])
            ->get();

        foreach ($assignments as $assignment) {
            foreach ($rules as $rule) {
                if ($rule->job_role_uuid !== null && (string) $rule->job_role_uuid !== (string) $assignment->job_role_uuid) {
                    continue;
                }

                if ($this->scopeMatches($assignment->scope, $rule->scope)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function scopeMatches(?Model $assigned, ?Model $required): bool
    {
        if (! $required instanceof Model) {
            return true;
        }

        if (! $assigned instanceof Model) {
            return false;
        }

        if ($assigned->is($required)) {
            return true;
        }

        return method_exists($assigned, 'coversScope') && (bool) $assigned->coversScope($required);
    }
}
