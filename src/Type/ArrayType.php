<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Type;

use Dziuperman\Sanitizer\Type;

/**
 * @psalm-immutable
 */
final class ArrayType implements Type
{
    /**
     * @psalm-param Type $elementType
     */
    public function __construct(
        public readonly Type $elementType
    )
    {
    }
}