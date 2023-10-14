<?php

namespace Dustin\Encapsulation;

/**
 * Provides implementation of {@see} \ArrayAccess methods for encapsulations.
 */
trait ArrayAccessTrait
{
    /**
     * @ignore
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->has(\strval($offset));
    }

    /**
     * @ignore
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get(\strval($offset));
    }

    /**
     * @ignore
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (\is_null($offset)) {
            throw new \RuntimeException('You can not set a value to an Encapsulation without offset.');
        }

        $this->set(\strval($offset), $value);
    }

    /**
     * @ignore
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->unset(\strval($offset));
    }
}
