<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rimba\Knowledge\Services\ScoreCalculator;

final class ScoreCalculatorTest extends TestCase
{
    public function test_exact_match_is_order_independent_and_rejects_partial_answers(): void
    {
        $calculator = new ScoreCalculator();
        self::assertTrue($calculator->isExactMatch(['b', 'a'], ['a', 'b']));
        self::assertFalse($calculator->isExactMatch(['a'], ['a', 'b']));
    }

    public function test_percentage_is_rounded_and_handles_zero_total(): void
    {
        $calculator = new ScoreCalculator();
        self::assertSame(66.67, $calculator->percentage(2, 3));
        self::assertSame(0.0, $calculator->percentage(0, 0));
    }
}
