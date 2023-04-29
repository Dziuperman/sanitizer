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
 * @covers \Dziuperman\Sanitizer\Type\StringTypeHandler
 *
 * @small
 */
class StringTypeHandlerTest extends TestCase
{
    /**
     * @dataProvider provideInvalidType
     */
    public function testInvalidType(mixed $value): void
    {
        $sanitizer = $this->createSanitizer();
        $handler = new StringTypeHandler();
        $type = new StringType();

        $result = $handler->handle($value, $type, $sanitizer);

        self::assertEquals(
            [
                Error::invalidType($value, 'string'),
            ],
            $result->getErrors()
        );
    }

    /**
     * @psalm-return Generator<int, array{mixed}>
     */
    public static function provideInvalidType(): Generator
    {
        yield [0];
        yield [123];
        yield [-123];
        yield [12.34];
        yield [-12.34];
        yield [true];
        yield [false];
        yield [[]];
        yield [['foo', 'bar']];
        yield [['foo' => 'bar']];
        yield [new stdClass()];
    }

    /**
     * @dataProvider  provideValidType
     */
    public function testValidType(mixed $value)
    {
        $sanitizer = $this->createSanitizer();
        $handler = new StringTypeHandler();
        $type = new StringType();

        $result = $handler->handle($value, $type, $sanitizer);

        self::assertCount(0, $result->getErrors());
    }

    public static function provideValidType(): Generator
    {
        yield [null];
        yield [''];
        yield ['string'];
    }

    private function createSanitizer(): Sanitizer
    {
        return new Sanitizer(
            new InMemoryTypeHandlerRegistry([])
        );
    }
}
