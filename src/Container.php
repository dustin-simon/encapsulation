<?php

namespace Dustin\Encapsulation;

class Container implements \Countable, \IteratorAggregate, \JsonSerializable
{
    use IteratorTrait;

    use JsonSerializableTrait;

    public const ASCENDING = true;

    public const DESCENDING = false;

    private array $elements = [];

    /**
     * @param mixed[] $elements
     */
    public function __construct(array $elements = [])
    {
        $this->add(...$elements);
    }

    public static function merge(self ...$containers): self
    {
        $new = new static();

        foreach ($containers as $container) {
            $new->add(...$container->toArray());
        }

        return $new;
    }

    public function toArray(): array
    {
        return array_values($this->elements);
    }

    public function copy(): self
    {
        return new static($this->elements);
    }

    /**
     * @param mixed ...$elements
     */
    public function add(...$elements): self
    {
        foreach ($elements as $element) {
            $this->validateType($element);
            $this->elements[] = $element;
        }

        return $this;
    }

    public function clear(): self
    {
        $this->elements = [];

        return $this;
    }

    /**
     * @return mixed|null
     */
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

    public function map(callable $callable): self
    {
        return new static(array_map($callable, array_values($this->elements)));
    }

    /**
     * @return mixed|null
     */
    public function reduce(callable $callable, $initial = null)
    {
        return array_reduce($this->elements, $callable, $initial);
    }

    public function filter(?callable $callable = null): self
    {
        // callback param is only nullable in PHP8
        return $callable === null ?
            new static(array_filter($this->elements)) :
            new static(array_filter($this->elements, $callable));
    }

    public function slice(int $offset, ?int $length = null): self
    {
        return new static(array_slice(array_values($this->elements), $offset, $length));
    }

    public function splice(int $offset, ?int $length = null, $replacement = []): self
    {
        array_splice($this->elements, $offset, $length, $replacement);

        return $this;
    }

    public function unique(int $flags = SORT_STRING): self
    {
        return new static(array_values(array_unique($this->elements, $flags)));
    }

    /**
     * @return mixed|null
     */
    public function shift()
    {
        return array_shift($this->elements);
    }

    /**
     * @param mixed ...$elements
     */
    public function unshift(...$elements): self
    {
        array_unshift($this->elements, ...$elements);

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function pop()
    {
        return array_pop($this->elements);
    }

    public function replace(array ...$arrays): self
    {
        return new static(array_replace($this->elements, ...$arrays));
    }

    /**
     * @param mixed|null $arg
     */
    public function walk(callable $callable, $arg = null): self
    {
        array_walk($this->elements, $callable, $arg);

        return $this;
    }

    public function reverse(): self
    {
        return new static(array_reverse($this->elements));
    }

    public function search($needle, bool $strict = false): ?int
    {
        return array_search($needle, array_values($this->elements), $strict);
    }

    public function has($value): bool
    {
        return in_array($value, $this->elements);
    }

    public function sort(?callable $callable = null, bool $direction = self::ASCENDING, int $flags = SORT_REGULAR): self
    {
        if ($callable !== null) {
            usort($this->elements, $callable);
        } elseif ($direction) {
            sort($this->elements, $flags);
        } else {
            rsort($this->elements, $flags);
        }

        return $this;
    }

    /**
     * @return Container[]
     */
    public function chunk(int $length): array
    {
        return array_map(function (array $chunk) {
            return new static($chunk);
        }, array_chunk($this->elements, $length));
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
