<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rimba\Knowledge\Support\StableUuid;

final class StableUuidTest extends TestCase
{
    public function test_same_namespace_and_name_are_stable(): void
    {
        $namespace = '2d54a2b7-8fb6-5a3a-a4e5-b9c67cf8a80b';
        self::assertSame(StableUuid::v5($namespace, 'staff:one'), StableUuid::v5($namespace, 'staff:one'));
        self::assertNotSame(StableUuid::v5($namespace, 'staff:one'), StableUuid::v5($namespace, 'staff:two'));
    }
}
