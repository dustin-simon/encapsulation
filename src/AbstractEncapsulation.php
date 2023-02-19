<?php

namespace Dustin\Encapsulation;

abstract class AbstractEncapsulation implements EncapsulationInterface
{
    use EncapsulationTrait;

    use ArrayAccessTrait;

    abstract public function __construct(array $data = []);

    public function getIterator(): \Traversable
    {
        yield from $this->toArray();
    }

    public function isEmpty(): bool
    {
        return empty($this->toArray());
    }

    public function __clone()
    {
        foreach ($this->toArray() as $field => $value) {
            if (\is_object($value)) {
                $this->set($field, clone $value);
            }
        }
    }
}
