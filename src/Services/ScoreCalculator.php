<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Services;

final class ScoreCalculator
{
    /** @param array<int, string> $selected @param array<int, string> $correct */
    public function isExactMatch(array $selected, array $correct): bool
    {
        $normalize = static function (array $values): array {
            $values = array_values(array_unique(array_map('strval', $values)));
            sort($values);
            return $values;
        };

        return $normalize($selected) === $normalize($correct);
    }

    public function percentage(float $earned, float $total): float
    {
        return $total <= 0 ? 0.0 : round(($earned / $total) * 100, 2);
    }
}
