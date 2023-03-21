<?php

namespace Dustin\Encapsulation;

trait IteratorTrait
{
    public function getIterator(): \Traversable
    {
        yield from $this->toArray();
    }
}
