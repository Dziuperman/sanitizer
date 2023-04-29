<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer\Type;

use Dziuperman\Sanitizer\Type;

/**
 * @psalm-immutable
 */
final class StructType implements Type
{
    /**
     * @psalm-var list<FieldType> $fields
     */
    private array $fields;

    public function __construct(FieldType ...$fields)
    {
        $this->fields = $fields;
    }

    /**
     * @psalm-return list<FieldType>
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}