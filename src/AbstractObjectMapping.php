<?php

namespace Dustin\Encapsulation;

abstract class AbstractObjectMapping extends ArrayEncapsulation
{
    abstract protected function getType(): string;

    public function set(string $field, $value): void
    {
        $this->validateType($value);

        parent::set($field, $value);
    }

    private function validateType($value)
    {
        $class = $this->getType();

        if (!$value instanceof $class) {
            throw new \InvalidArgumentException(sprintf('Value must be %s. %s given'), $class, is_object($value) ? get_class($object) : gettype($object));
        }
    }
}
