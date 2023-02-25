<?php

namespace Dustin\Encapsulation;

use Dustin\Encapsulation\Exception\NotAllowedFieldException;

abstract class ArrayEncapsulation extends AbstractEncapsulation
{
    private array $data = [];

    public function __construct(array $data = [])
    {
        $this->setList($data);
    }

    public function set(string $field, $value): void
    {
        $this->validateField($field);

        $this->data[$field] = $value;
    }

    public function unset(string $field): void
    {
        unset($this->data[$field]);
    }

    public function get(string $field)
    {
        if (!$this->has($field)) {
            return null;
        }

        return $this->data[$field];
    }

    public function has(string $field): bool
    {
        return \array_key_exists($field, $this->data);
    }

    public function getFields(): array
    {
        return array_keys($this->data);
    }

    /**
     * This method can be overwritten to optionally return a list of allowed fields.
     * Trying to set other fields will throw an exception.
     */
    public function getAllowedFields(): ?array
    {
        return null;
    }

    private function validateField(string $field)
    {
        $allowedFields = $this->getAllowedFields();

        if ($allowedFields === null) {
            return;
        }

        if (!in_array($field, $allowedFields)) {
            throw new NotAllowedFieldException($this, $field);
        }
    }
}
