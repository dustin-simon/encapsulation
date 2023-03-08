<?php

namespace Dustin\Encapsulation;

use Dustin\Encapsulation\Exception\ImmutableException;

class ImmutableContainer extends Container
{
    public function __construct(array $elements = [])
    {
        parent::add(...$elements);
    }

    public static function merge(Container ...$containers): Container
    {
        $elements = [];

        foreach ($containers as $container) {
            $elements = array_merge($elements, $container->toArray());
        }

        return new static($elements);
    }

    public function add(...$elements): Container
    {
        throw new ImmutableException($this);
    }

    public function clear(): self
    {
        throw new ImmutableException($this);
    }

    public function shift()
    {
        throw new ImmutableException($this);
    }

    public function unshift(...$elements): Container
    {
        throw new ImmutableException($this);
    }

    public function pop()
    {
        throw new ImmutableException($this);
    }
}
