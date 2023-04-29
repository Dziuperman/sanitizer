<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Type;

use Dziuperman\Sanitizer\Error;
use Dziuperman\Sanitizer\Sanitizer;
use Dziuperman\Sanitizer\TypeHandlerRegistry\InMemoryTypeHandlerRegistry;
use Generator;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @internal
 * @covers \Dziuperman\Sanitizer\Type\FloatTypeHandler
 *
 * @small
 */
class FloatTypeHandlerTest extends TestCase
{
    /**
     * @dataProvider provideInvalidType
     */
    public function testInvalidType(mixed $value): void
    {
        $sanitizer = $this->createSanitizer();
        $handler = new FloatTypeHandler();
        $type = new FloatType();

        $result = $handler->handle($value, $type, $sanitizer);

        self::assertEquals(
            [
                Error::invalidType($value, 'float'),
            ],
            $result->getErrors()
        );
    }

    public static function provideInvalidType(): Generator
    {
        yield [0];
        yield [123];
        yield [-123];
        yield ['0'];
        yield ['0.0'];
        yield ['foo'];
        yield [false];
        yield [true];
        yield [[]];
        yield ['foo', 'bar'];
        yield ['foo' => 'bar'];
        yield [new stdClass()];
    }

    /**
     * @dataProvider provideValidType
     */
    public function testValidType(mixed $value): void
    {
        $sanitizer = $this->createSanitizer();
        $handler = new FloatTypeHandler();
        $type = new FloatType();

        $result = $handler->handle($value, $type, $sanitizer);

        self::assertCount(0, $result->getErrors());
    }

    public static function provideValidType(): Generator
    {
        yield [null];
        yield [0.0];
        yield [-0.0];
        yield [12.34];
        yield [-12.34];
    }

    private function createSanitizer(): Sanitizer
    {
        return new Sanitizer(
            new InMemoryTypeHandlerRegistry([])
        );
    }
}
