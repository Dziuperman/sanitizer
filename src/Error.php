<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer;

/**
 * @psalm-immutable
 */
final class Error
{
    private const INVALID_TYPE = '9ab3eec6-ec67-4968-afc1-5e7c2ec477f4';

    /**
     * @psalm-param array<string, mixed> $variables
     */
    public function __construct(
        public readonly string $code,
        public readonly string $message,
        private array $variables = [
            'path' => [],
            'field' => null,
        ],
        private string $path = ''
    )
    {
    }

    public static function invalidType(mixed $value, string $expectedType, string ...$expectedTypes): self
    {
        return new self(
            self::INVALID_TYPE,
            'Invalid type {actual_type}, expected {expected_types}',
            [
                'actual_type' => get_debug_type($value),
                'expected_types' => implode('|', [$expectedType, ...$expectedTypes]),
            ]
        );
    }

    public function atProperty(string $property): self
    {
        $error = clone $this;
        $error->path = sprintf('.%s%s', $property, $this->path);

        /** @var list<int|string> $path */
        $path = $error->variables['path'] ?? [];
        $error->variables['path'] = [$property, ...$path];

        return $error;
    }

    public function atOffset(int $offset): self
    {
        $error = clone $this;
        $error->path = sprintf('[%s]%s', $offset, $this->path);

        /** @var list<int|string> $path */
        $path = $error->variables['path'] ?? [];
        $error->variables['path'] = [$offset, ...$path];

        return $error;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}