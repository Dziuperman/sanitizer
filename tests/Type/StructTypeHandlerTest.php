<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Type;

use Dziuperman\Sanitizer\Error;
use Dziuperman\Sanitizer\Sanitizer;
use Dziuperman\Sanitizer\TypeHandlerRegistry\InMemoryTypeHandlerRegistry;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \Dziuperman\Sanitizer\Type\StructTypeHandler
 *
 * @small
 */
class StructTypeHandlerTest extends TestCase
{
    /**
     * @dataProvider provideInvalidType
     */
    public function testInvalidType(mixed $value): void
    {
        $sanitizer = $this->createSanitizer();
        $handler = new StructTypeHandler();
        $type = new StructType();

        $result = $handler->handle($value, $type, $sanitizer);

        self::assertEquals(
            [
                Error::invalidType($value, 'struct'),
            ],
            $result->getErrors(),
        );
    }

    public static function provideInvalidType(): Generator
    {
        yield [[]];
        yield [null];
        yield [['foo', 1122, 11.22]];
        yield [0 => 'foo', 1 => 'bar'];
        yield ['0' => 'foo', '1' => 'bar'];
    }

    /**
     * @dataProvider provideValidType
     */
    public function testValidType(mixed $value): void
    {
        $sanitizer = $this->createSanitizer();
        $handler = new StructTypeHandler();
        $type = new StructType();

        $result = $handler->handle($value, $type, $sanitizer);

        self::assertCount(0, $result->getErrors());
    }

    public static function provideValidType(): Generator
    {
        yield [['foo' => 'bar']];
    }

    private function createSanitizer(): Sanitizer
    {
        return new Sanitizer(
            new InMemoryTypeHandlerRegistry([])
        );
    }
}
