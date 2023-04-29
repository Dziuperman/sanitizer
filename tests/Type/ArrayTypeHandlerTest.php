<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Type;

use Dziuperman\Sanitizer\Error;
use Dziuperman\Sanitizer\Sanitizer;
use Dziuperman\Sanitizer\Type;
use Dziuperman\Sanitizer\TypeHandlerRegistry\InMemoryTypeHandlerRegistry;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \Dziuperman\Sanitizer\Type\ArrayTypeHandler
 *
 * @small
 */
class ArrayTypeHandlerTest extends TestCase
{
    /**
     * @dataProvider provideInvalidType
     */
    public function testInvalidType(Type $elementType, mixed $value): void
    {
        $sanitizer = $this->createSanitizer();
        $handler = new ArrayTypeHandler();
        $type = new ArrayType($elementType);

        $result = $handler->handle($value, $type, $sanitizer);

        self::assertEquals(
            [
                Error::invalidType($value, 'array'),
            ],
            $result->getErrors()
        );
    }

    /**
     * @psalm-return Generator<int, array{Type, mixed}>
     */
    public static function provideInvalidType(): Generator
    {
        yield [new StringType(), 'string'];
    }

    private function createSanitizer(): Sanitizer
    {
        return new Sanitizer(
            new InMemoryTypeHandlerRegistry([
                new StringTypeHandler(),
            ])
        );
    }
}
