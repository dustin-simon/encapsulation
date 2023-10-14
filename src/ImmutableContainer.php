<?php

namespace Dustin\Encapsulation;

use Dustin\Encapsulation\Exception\ImmutableException;

/**
 * A container which cannot be changed after initialization.
 *
 * Elements cannot be removed nor added but sorted.
 */
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

    /**
     * @throws ImmutableException
     */
    public function add(mixed ...$elements): Container
    {
        throw new ImmutableException($this);
    }

    /**
     * @throws ImmutableException
     */
    public function clear(): Container
    {
        throw new ImmutableException($this);
    }

    /**
     * @throws ImmutableException
     */
    public function splice(int $offset, ?int $length = null, mixed $replacement = []): Container
    {
        throw new ImmutableException($this);
    }

    /**
     * @throws ImmutableException
     */
    public function shift(): mixed
    {
        throw new ImmutableException($this);
    }

    /**
     * @throws ImmutableException
     */
    public function unshift(mixed ...$elements): Container
    {
        throw new ImmutableException($this);
    }

    /**
     * @throws ImmutableException
     */
    public function pop(): mixed
    {
        throw new ImmutableException($this);
    }
}
