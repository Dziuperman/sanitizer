<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Stub;

use Dziuperman\Sanitizer\Error;
use Dziuperman\Sanitizer\Result;
use Dziuperman\Sanitizer\Sanitizer;
use Dziuperman\Sanitizer\Type;
use Dziuperman\Sanitizer\TypeHandler;

/**
 * @implements TypeHandler<InvalidType>
 */
final class InvalidTypeHandler implements TypeHandler
{
    private static ?Error $error = null;

    public static function type(): string
    {
        return InvalidType::class;
    }

    public static function error(): ?Error
    {
        return self::$error ??= new Error('', 'message template', ['variable' => 'value']);
    }

    /**
     * @param InvalidType $type
     */
    public function handle(mixed $value, Type $type, Sanitizer $sanitizer): Result
    {
        $result = new Result();
        $result->addError(self::error());

        return $result;
    }
}