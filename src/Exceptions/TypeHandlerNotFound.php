<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Exceptions;

use Dziuperman\Sanitizer\Type;

class TypeHandlerNotFound extends \RuntimeException
{
    /**
     * @param class-string<Type> $type
     */
    public static function forType(string $type, \Throwable $previous = null): self
    {
        return new self(sprintf('No handler found for type "%s"', $type), 0, $previous);
    }
}