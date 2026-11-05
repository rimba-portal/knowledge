<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Rimba\Knowledge\Contracts\CurrentStaffResolver;
use Rimba\People\Models\Staff;
use RuntimeException;

final class ConfiguredCurrentStaffResolver implements CurrentStaffResolver
{
    public function resolve(): Staff
    {
        $user = Auth::user();
        $staffClass = config('bites.knowledge.models.staff', Staff::class);

        if ($user instanceof $staffClass) {
            return $user;
        }

        $related = $this->relatedStaff($user);
        if ($related instanceof $staffClass) {
            return $related;
        }

        $query = $staffClass::query();
        $table = $query->getModel()->getTable();

        if ($user instanceof Authenticatable && Schema::hasColumn($table, 'user_id')) {
            $staff = $query->where('user_id', $user->getAuthIdentifier())->first();
            if ($staff instanceof $staffClass) {
                return $staff;
            }
        }

        if ($user && filled($user->email ?? null) && Schema::hasColumn($table, 'email')) {
            $staff = $query->where('email', $user->email)->first();
            if ($staff instanceof $staffClass) {
                return $staff;
            }
        }

        throw new RuntimeException('Unable to resolve the authenticated user to a Rimba Staff record. Bind CurrentStaffResolver for this application.');
    }

    private function relatedStaff(mixed $user): mixed
    {
        if (! is_object($user)) {
            return null;
        }

        if (method_exists($user, 'staff')) {
            $relation = $user->staff();

            return method_exists($relation, 'first') ? $relation->first() : null;
        }

        return $user->staff ?? null;
    }
}
