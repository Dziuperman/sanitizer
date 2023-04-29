<?php

declare(strict_types=1);

namespace Dziuperman\Sanitizer;

final class Result
{
    private mixed $value = null;
    /**
     * @psalm-var list<Error>
     */
    private array $errors = [];

    public function addError(Error $error): void
    {
        $this->errors[] = $error;
    }

    public function addValue($value): void
    {
        $this->value = $value;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @psalm-return list<Error>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    public function isValid(): bool
    {
        return count($this->errors) === 0;
    }
}