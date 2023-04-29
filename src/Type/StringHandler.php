<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Type;

use Dziuperman\Sanitizer\Error;
use Dziuperman\Sanitizer\Result;
use Dziuperman\Sanitizer\Sanitizer;
use Dziuperman\Sanitizer\Type;
use Dziuperman\Sanitizer\TypeHandler;

/**
 * @implements TypeHandler<StringType>
 */
final class StringHandler implements TypeHandler
{
    public static function type(): string
    {
        return StringType::class;
    }

    /**
     * @param StringType $type
     */
    public function handle(mixed $value, Type $type, Sanitizer $sanitizer): Result
    {
        $result = new Result();

        if ($value === null) {
            $result->addValue(null);

            return $result;
        }

        if (!is_string($value)) {
            $result->addError(Error::invalidType($value, 'string'));

            return $result;
        }

        $result->addValue($value);

        return $result;
    }
}