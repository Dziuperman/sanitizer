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
 * @covers \Dziuperman\Sanitizer\Type\IntTypeHandler
 *
 * @small
 */
class IntTypeHandlerTest extends TestCase
{
    /**
     * @dataProvider provideInvalidType
     */
    public function testInvalidType(mixed $value): void
    {
        $sanitizer = $this->createSanitizer();
        $handler = new IntTypeHandler();
        $type = new IntType();

        $result = $handler->handle($value, $type, $sanitizer);

        self::assertEquals(
            [
                Error::invalidType($value, 'integer')
            ],
            $result->getErrors()
        );
    }

    public static function provideInvalidType(): Generator
    {
        yield [12.34];
        yield [-12.34];
        yield ['0'];
        yield ['0.0'];
        yield [true];
        yield [false];
        yield [[]];
        yield [['foo', 'bar']];
        yield [['foo' => 'bar']];
        yield [new stdClass()];
    }

    /**
     * @dataProvider provideValidType
     */
    public function testValidType(mixed $value): void
    {
        $sanitizer = $this->createSanitizer();
        $handler = new IntTypeHandler();
        $type = new IntType();

        $result = $handler->handle($value, $type, $sanitizer);

        self::assertCount(0, $result->getErrors());
    }

    public static function provideValidType(): Generator
    {
        yield [0];
        yield [1234];
        yield [-1234];
    }

    private function createSanitizer(): Sanitizer
    {
        return new Sanitizer(
            new InMemoryTypeHandlerRegistry([])
        );
    }
}
