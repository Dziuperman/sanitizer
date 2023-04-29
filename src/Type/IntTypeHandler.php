<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Type;

use Dziuperman\Sanitizer\Error;
use Dziuperman\Sanitizer\Result;
use Dziuperman\Sanitizer\Sanitizer;
use Dziuperman\Sanitizer\Type;
use Dziuperman\Sanitizer\TypeHandler;

/**
 * @implements TypeHandler<IntType>
 */
final class IntTypeHandler implements TypeHandler
{
    public static function type(): string
    {
        return IntType::class;
    }

    /**
     * @param IntType $type
     */
    public function handle(mixed $value, Type $type, Sanitizer $sanitizer): Result
    {
        $result = new Result();

        if ($value === null) {
            $result->addValue(null);

            return $result;
        }

        if (!is_int($value)) {
            $result->addError(Error::invalidType($value, 'integer'));

            return $result;
        }

        $result->addValue($value);

        return $result;
    }
}