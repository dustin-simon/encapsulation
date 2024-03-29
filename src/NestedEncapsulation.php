<?php

namespace Dustin\Encapsulation;

/**
 * An {@see} ArrayEncapsulation which can only hold scalar values, arrays or other NestedEncapsulations.
 *
 * Adding a value other than a scalar, an array, null or another NestedEncapsulation will throw an exception.
 * Inner array values are also not allowed to hold not-supported values
 */
class NestedEncapsulation extends ArrayEncapsulation
{
    /**
     * @throws \InvalidArgumentException
     */
    public function set(string $field, mixed $value): void
    {
        $this->validate($value);

        parent::set($field, $value);
    }

    private function validate(mixed $value): void
    {
        if (
            $value === null ||
            \is_scalar($value)
        ) {
            return;
        }

        if (\is_object($value) &&
            $value instanceof self
        ) {
            return;
        }

        if (is_array($value)) {
            foreach ($value as $valueItem) {
                $this->validate($valueItem);
            }

            return;
        }

        throw new \InvalidArgumentException(\sprintf('A NestedEncapsulation can only contain scalar values, null, arrays or other NestedEncapsulations. %s given.', get_debug_type($value)));
    }
}
