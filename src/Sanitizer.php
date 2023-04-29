<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer;

final class Sanitizer
{
    public function __construct(
        private readonly TypeHandlerRegistry $typeHandlerRegistry
    )
    {
    }

    /**
     * @param mixed $value
     * @psalm-return Result
     */
    public function sanitize(mixed $value, Type $type): Result
    {
        return $this
            ->typeHandlerRegistry
            ->getTypeHandler(get_class($type))
            ->handle($value, $type, $this);
    }
}