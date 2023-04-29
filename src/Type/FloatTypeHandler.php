<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Type;

use Dziuperman\Sanitizer\Error;
use Dziuperman\Sanitizer\Result;
use Dziuperman\Sanitizer\Sanitizer;
use Dziuperman\Sanitizer\Type;
use Dziuperman\Sanitizer\TypeHandler;

/**
 * @implements TypeHandler<FloatType>
 */
final class FloatTypeHandler implements TypeHandler
{
    public static function type(): string
    {
        return FloatType::class;
    }

    /**
     * @param FloatType $type
     */
    public function handle(mixed $value, Type $type, Sanitizer $sanitizer): Result
    {
        $result = new Result();

        if ($value === null) {
            $result->addValue(null);

            return $result;
        }

        if (!is_float($value)) {
            $result->addError(Error::invalidType($value, 'float'));

            return $result;
        }

        $result->addValue($value);

        return $result;
    }
}