<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer;

use Dziuperman\Sanitizer\Exceptions\TypeHandlerNotFound;

interface TypeHandlerRegistry
{
    /**
     * @template T of Type
     * @psalm-param class-string<T> $type
     * @psalm-return TypeHandler<T>
     *
     * @throws TypeHandlerNotFound
     */
    public function getTypeHandler(string $type): TypeHandler;
}