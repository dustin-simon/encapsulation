<?php

namespace Dustin\Encapsulation;

use Dustin\Encapsulation\Exception\NotAnArrayException;

trait EncapsulationTrait
{
    public function setList(array $data): void
    {
        foreach ($data as $field => $value) {
            $this->set(\strval($field), $value);
        }
    }

    public function getList(array $fields): array
    {
        $result = [];

        foreach ($fields as $fieldName) {
            $result[$fieldName] = $this->get($fieldName);
        }

        return $result;
    }

    /**
     * @throws NotAnArrayException
     */
    public function add(string $field, $value): void
    {
        if (!$this->has($field)) {
            $this->set($field, [$value]);

            return;
        }

        $item = $this->get($field);

        if (\is_array($item)) {
            $item[] = $value;
            $this->set($field, $item);

            return;
        }

        throw new NotAnArrayException($this, $field);
    }

    public function addList(string $field, array $values): void
    {
        foreach ($values as $value) {
            $this->add($field, $value);
        }
    }

    public function toArray(): array
    {
        return $this->getList($this->getFields());
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function __serialize(): array
    {
        return array_map('serialize', $this->toArray());
    }

    public function __unserialize(array $data): void
    {
        $this->setList(array_map('unserialize', $data));
    }
}
