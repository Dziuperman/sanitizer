<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Type;

use Dziuperman\Sanitizer\Error;
use Dziuperman\Sanitizer\Result;
use Dziuperman\Sanitizer\Sanitizer;
use Dziuperman\Sanitizer\Type;
use Dziuperman\Sanitizer\TypeHandler;

/**
 * @implements TypeHandler<ArrayType>
 */
final class ArrayTypeHandler implements TypeHandler
{
    public static function type(): string
    {
        return ArrayType::class;
    }

    /**
     * @param ArrayType $type
     */
    public function handle(mixed $value, Type $type, Sanitizer $sanitizer): Result
    {
        $result = new Result();

        if ($value === null) {
           $result->addValue(null);

            return $result;
        }

        if (!(is_array($value) && array_is_list($value))) {
            $result->addError(Error::invalidType($value, 'array'));

            return $result;
        }

        /** @var list<mixed> $resultValue */
        $resultValue = [];

        foreach($value as $index => $element) {
            /** @var Result $result */
            $elementResult = $sanitizer->sanitize($element, $type->elementType);
            if ($elementResult->hasErrors()) {
                foreach($elementResult->getErrors() as $error) {
                    $result->addError($error->atOffset($index));
                }
            }

            $resultValue[] = $elementResult->getValue();
        }

        $result->addValue($resultValue);

        return $result;
    }
}