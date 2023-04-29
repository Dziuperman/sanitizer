<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer;

/**
 * @template T of Type
 */
interface TypeHandler
{
    /**
     * Class-string of handled type
     *
     * @psalm-return class-string<T>
     */
    public static function type(): string;

    /**
     * @param mixed $value
     * @psalm-param T $type
     * @psalm-return Result
     */
    public function handle(mixed $value, Type $type, Sanitizer $sanitizer): Result;
}