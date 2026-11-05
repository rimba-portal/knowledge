<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Contracts;

use Rimba\People\Models\Staff;

interface CurrentStaffResolver
{
    public function resolve(): Staff;
}
