<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\TypeHandlerRegistry;

use Dziuperman\Sanitizer\Exceptions\TypeHandlerNotFound;
use Dziuperman\Sanitizer\Type;
use Dziuperman\Sanitizer\TypeHandler;
use Dziuperman\Sanitizer\TypeHandlerRegistry;

final class InMemoryTypeHandlerRegistry implements TypeHandlerRegistry
{
    /**
     * @psalm-var array<class-string<Type>, TypeHandler>
     */
    private array $typeHandlers = [];

    /**
     * @psalm-param iterable<TypeHandler> $typeHandlers
     */
    public function __construct(iterable $typeHandlers)
    {
        foreach ($typeHandlers as $typeHandler) {
            $this->typeHandlers[$typeHandler::type()] = $typeHandler;
        }
    }

    /**
     * @template T of Type
     * @psalm-param class-string<T> $type
     * @psalm-return TypeHandler<T>
     */
    public function getTypeHandler(string $type): TypeHandler
    {
        if (!isset($this->typeHandlers[$type])) {
            throw TypeHandlerNotFound::forType($type);
        }

        /** @psalm-var TypeHandler<T> */
        return $this->typeHandlers[$type];
    }
}