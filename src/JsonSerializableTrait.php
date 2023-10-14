<?php

namespace Dustin\Encapsulation;

/**
 * Provides method implementations for \JsonSerializable.
 */
trait JsonSerializableTrait
{
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
