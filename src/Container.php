<?php

namespace Dustin\Encapsulation;

class Container implements \Countable, \IteratorAggregate, \JsonSerializable
{
    private array $elements = [];

    public function __construct(array $elements = [])
    {
        foreach ($elements as $e) {
            $this->add($e);
        }
    }

    public function toArray(): array
    {
        return $this->elements;
    }

    public function add($element): void
    {
        $this->validateType($element);
        $this->elements[] = $element;
    }

    public function getAt(int $position)
    {
        return array_values($this->elements)[$position] ?? null;
    }

    public function count(): int
    {
        return count($this->elements);
    }

    public function isEmpty(): bool
    {
        return empty($this->elements);
    }

    public function clear(): void
    {
        $this->elements = [];
    }

    public function getIterator(): \Traversable
    {
        yield from $this->elements;
    }

    public function jsonSerialize()
    {
        return array_values($this->elements);
    }

    public function __serialize(): array
    {
        return array_map('serialize', array_values($this->elements));
    }

    public function __unserialize(array $data): void
    {
        $this->elements = array_values(array_map('unserialize', $data));
    }

    protected function getAllowedClass(): ?string
    {
        return null;
    }

    private function validateType($element)
    {
        $class = $this->getAllowedClass();

        if ($class === null) {
            return;
        }

        if (!is_object($element) || !($element instanceof $class)) {
            $type = is_object($element) ? get_class($element) : gettype($element);

            throw new \InvalidArgumentException(sprintf('Container can only hold %s got %s', $class, $type));
        }
    }
}
