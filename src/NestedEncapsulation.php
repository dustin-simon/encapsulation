<?php

namespace Dustin\Encapsulation;

/**
 * Encapsulation class which can only hold scalar values, arrays or other NestedEncapsulations.
 */
class NestedEncapsulation extends Encapsulation
{
    public function set(string $field, $value): void
    {
        $this->validate($value);

        parent::set($field, $value);
    }

    private function validate($value)
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

        $type = is_object($value) ? get_class($value) : gettype($value);

        throw new \InvalidArgumentException(\sprintf('A NestedEncapsulation can only contain scalar values, null, arrays or other NestedEncapsulations. %s given.', $type));
    }
}
