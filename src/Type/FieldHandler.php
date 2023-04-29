<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Type;

use Dziuperman\Sanitizer\Result;
use Dziuperman\Sanitizer\Sanitizer;
use Dziuperman\Sanitizer\Type;
use Dziuperman\Sanitizer\TypeHandler;

/**
 * @implements TypeHandler<Field>
 */
final class FieldHandler implements TypeHandler
{
    public static function type(): string
    {
        return Field::class;
    }

    /**
     * @param Field $type
     */
    public function handle(mixed $value, Type $type, Sanitizer $sanitizer): Result
    {
        return $sanitizer->sanitize($value, $type->value);
    }
}