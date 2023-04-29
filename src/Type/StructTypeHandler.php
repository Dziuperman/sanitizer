<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Type;

use Dziuperman\Sanitizer\Error;
use Dziuperman\Sanitizer\Result;
use Dziuperman\Sanitizer\Sanitizer;
use Dziuperman\Sanitizer\Type;
use Dziuperman\Sanitizer\TypeHandler;

/**
 * @implements TypeHandler<StructType>
 */
final class StructTypeHandler implements TypeHandler
{
    private const PROPERTY_DOES_NOT_EXIST = '9fe39fea-ffbd-4653-b7cc-7e6a95be5928';

    public static function type(): string
    {
        return StructType::class;
    }

    /**
     * @param StructType $type
     */
    public function handle(mixed $value, Type $type, Sanitizer $sanitizer): Result
    {
        $result = new Result();

        if (empty($value) || !is_array($value) || array_is_list($value)) {
            $result->addError(Error::invalidType($value, 'struct'));

            return $result;
        }

        /**
         * @psalm-var array<string|int, mixed> $value
         */
        $resultValue = [];

        /** @var FieldType $field */
        foreach ($type->getFields() as $field) {
            if (!array_key_exists($field->key, $value)) {
                $result->addError(new Error(
                    self::PROPERTY_DOES_NOT_EXIST,
                    'Field {{ field }} does not exist in struct.',
                    [
                        'field' => $field,
                    ]
                ));

                continue;
            }

            $childResult = $sanitizer->sanitize($value[$field->key], $field->value);
            if ($childResult->hasErrors()) {
                foreach ($childResult->getErrors() as $error) {
                    $result->addError($error->atProperty($field->key));
                }
            }

            $resultValue[$field->key] = $childResult->getValue();
        }

        $result->addValue($resultValue);

        return $result;
    }
}