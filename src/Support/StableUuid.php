<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Support;

use InvalidArgumentException;

final class StableUuid
{
    public static function v5(string $namespace, string $name): string
    {
        $hex = str_replace(['-', '{', '}'], '', strtolower($namespace));
        if (strlen($hex) !== 32 || ! ctype_xdigit($hex)) {
            throw new InvalidArgumentException('The namespace must be a valid UUID.');
        }

        $bytes = hex2bin($hex);
        $hash = sha1($bytes.$name);
        $timeHi = (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000;
        $clockSeq = (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000;

        return sprintf('%s-%s-%04x-%04x-%s', substr($hash, 0, 8), substr($hash, 8, 4), $timeHi, $clockSeq, substr($hash, 20, 12));
    }
}
