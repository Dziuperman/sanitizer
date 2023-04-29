<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Type;

use Dziuperman\Sanitizer\Type;

/**
 * @psalm-immutable
 */
final class Field implements Type
{
    public function __construct(
        public readonly string|int $key,
        public readonly Type $value
    )
    {
    }
}