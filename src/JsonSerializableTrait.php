<?php

namespace Dustin\Encapsulation;

trait JsonSerializableTrait
{
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
