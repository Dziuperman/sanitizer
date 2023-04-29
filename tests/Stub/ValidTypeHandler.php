<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Stub;

use Dziuperman\Sanitizer\Error;
use Dziuperman\Sanitizer\Result;
use Dziuperman\Sanitizer\Sanitizer;
use Dziuperman\Sanitizer\Type;
use Dziuperman\Sanitizer\TypeHandler;

/**
 * @implements TypeHandler<ValidType>
 */
final class ValidTypeHandler implements TypeHandler
{
    public static function type(): string
    {
        return ValidType::class;
    }

    /**
     * @param ValidType $type
     */
    public function handle(mixed $value, Type $type, Sanitizer $sanitizer): Result
    {
        return new Result();
    }
}