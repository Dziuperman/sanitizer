<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer;

use Dziuperman\Sanitizer\Stub\InvalidType;
use Dziuperman\Sanitizer\Stub\InvalidTypeHandler;
use Dziuperman\Sanitizer\Stub\ValidType;
use Dziuperman\Sanitizer\Stub\ValidTypeHandler;
use Dziuperman\Sanitizer\TypeHandlerRegistry\InMemoryTypeHandlerRegistry;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \Dziuperman\Sanitizer\Sanitizer
 *
 * @small
 */
class SanitizerTest extends TestCase
{
    public function testSanitizeInvalid(): void
    {
        $sanitizer = new Sanitizer(
            new InMemoryTypeHandlerRegistry([
                new InvalidTypeHandler(),
            ])
        );

        $result = $sanitizer->sanitize(1, new InvalidType());

        /**
         * @psalm-var list<Error> $expectedErrors
         */
        $expectedErrors = [InvalidTypeHandler::error()];
        self::assertSame($expectedErrors, $result->getErrors());
    }

    public function testSanitizeValid(): void
    {
        $sanitizer = new Sanitizer(
            new InMemoryTypeHandlerRegistry([
                new ValidTypeHandler(),
            ])
        );

        $result = $sanitizer->sanitize(1, new ValidType());

        self::assertCount(0, $result->getErrors());
    }
}
