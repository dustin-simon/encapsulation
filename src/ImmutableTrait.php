<?php

namespace Dustin\Encapsulation;

use Dustin\Encapsulation\Exception\EncapsulationImmutableException;

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
        throw new EncapsulationImmutableException($this);
    }
}
