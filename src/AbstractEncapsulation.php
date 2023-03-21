<?php

namespace Dustin\Encapsulation;

/**
 * The base class of any encapsulation.
 *
 * Implements some methods from the {@see} EncapsulationInterface without caring of data storage.
 */
abstract class AbstractEncapsulation implements EncapsulationInterface
{
    use EncapsulationTrait;

    use ArrayAccessTrait;

    use IteratorTrait;
    /**
     * Optionally initializes the encapsulation with data.
     *
     * Takes an optional associative array holding some data to be initialized with.
     *
     * @param array<string, mixed> $data An associative array holding data
     */
    abstract public function __construct(array $data = []);

    use JsonSerializableTrait;

    /**
     * Checks if an encapsulation is empty.
     *
     * @return bool Wether the encapsulation has data or not
     */
    public function isEmpty(): bool
    {
        return empty($this->toArray());
    }

    /**
     * Returns true of false wether the data of an encapsulation can be changed.
     */
    public function isMutable(): bool
    {
        return true;
    }

    /**
     * Returns a list of all fields which both encapsulations have in common.
     *
     * @see IntersectionCalculation::getFieldIntersection
     *
     * @return string[]
     */
    public function getFieldIntersection(EncapsulationInterface $encapsulation): array
    {
        return IntersectionCalculation::getFieldIntersection($this, $encapsulation);
    }

    /**
     * Returns a list of all fields which are not available in $encapsulation.
     *
     * @see IntersectionCalculation::getFieldDifference
     *
     * @return string[]
     */
    public function getFieldDifference(EncapsulationInterface $encapsulation): array
    {
        return IntersectionCalculation::getFieldDifference($this, $encapsulation);
    }

    /**
     * Returns a new encapsulation representing all data which both encapsulations have in common.
     *
     * @see IntersectionCalculation::getIntersection
     */
    public function getIntersection(self $encapsulation): EncapsulationInterface
    {
        return IntersectionCalculation::getIntersection($this, $encapsulation);
    }

    /**
     * Returns a new encapsulation representing all data which differ from $encapsulation.
     *
     * @see IntersectionCalculation::getDifference
     */
    public function getDifference(self $encapsulation): EncapsulationInterface
    {
        return IntersectionCalculation::getDifference($this, $encapsulation);
    }

    /**
     * @ignore
     */
    public function __clone()
    {
        foreach ($this->toArray() as $field => $value) {
            if (\is_object($value)) {
                $this->set($field, clone $value);
            }
        }
    }
}
