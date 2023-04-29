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
 * @covers \Dziuperman\Sanitizer\Type\StringHandler
 *
 * @small
 */
class StringHandlerTest extends TestCase
{
    /**
     * @dataProvider provideInvalidType
     */
    public function testInvalidType(mixed $value): void
    {
        $sanitizer = $this->createSanitizer();
        $handler = new StringHandler();
        $type = new StringType();

        $result = $handler->handle($value, $type, $sanitizer);

        self::assertEquals(
            [
                Error::invalidType($value, 'string')
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
     * @internal
     * @dataProvider  provideValid
     *
     * @small
     */
    public function testValid(mixed $value)
    {
        $sanitizer = $this->createSanitizer();
        $handler = new StringHandler();
        $type = new StringType();

        $result = $handler->handle($value, $type, $sanitizer);

        self::assertSame(0, count($result->getErrors()));
    }

    public static function provideValid(): Generator
    {
        yield [null];
        yield [''];
        yield ['string'];
    }

    private function createSanitizer(): Sanitizer
    {
        return new Sanitizer(
            new InMemoryTypeHandlerRegistry([
                new StringHandler(),
            ])
        );
    }
}
