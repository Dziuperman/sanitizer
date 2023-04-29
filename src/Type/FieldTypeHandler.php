<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Type;

use Dziuperman\Sanitizer\Result;
use Dziuperman\Sanitizer\Sanitizer;
use Dziuperman\Sanitizer\Type;
use Dziuperman\Sanitizer\TypeHandler;

/**
 * @implements TypeHandler<FieldType>
 */
final class FieldTypeHandler implements TypeHandler
{
    public static function type(): string
    {
        return FieldType::class;
    }

    /**
     * @param FieldType $type
     */
    public function handle(mixed $value, Type $type, Sanitizer $sanitizer): Result
    {
        return $sanitizer->sanitize($value, $type->value);
    }
}