<?php

namespace Dustin\Encapsulation;

use Dustin\Encapsulation\Exception\ImmutableException;

trait ImmutableTrait
{
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            parent::set($key, $value);
        }
    }

    public function set(string $field, $value): void
    {
        throw new ImmutableException($this);
    }

    public function add(string $field, $value): void
    {
        throw new ImmutableException($this);
    }

    public function isMutable(): bool
    {
        return false;
    }
}
