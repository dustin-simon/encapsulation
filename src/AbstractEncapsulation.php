<?php

namespace Dustin\Encapsulation;

abstract class AbstractEncapsulation implements EncapsulationInterface
{
    use EncapsulationTrait;

    use ArrayAccessTrait;

    abstract public function __construct(array $data = []);

    public function getIterator(): \Traversable
    {
        yield from $this->toArray();
    }

    public function isEmpty(): bool
    {
        return empty($this->toArray());
    }

    public function isMutable(): bool
    {
        return true;
    }

    public function getFieldIntersection(EncapsulationInterface $encapsulation): array
    {
        return IntersectionCalculation::getFieldIntersection($this, $encapsulation);
    }

    public function getFieldDifference(EncapsulationInterface $encapsulation): array
    {
        return IntersectionCalculation::getFieldDifference($this, $encapsulation);
    }

    public function getIntersection(EncapsulationInterface $encapsulation): EncapsulationInterface
    {
        return IntersectionCalculation::getIntersection($this, $encapsulation);
    }

    public function getDifference(EncapsulationInterface $encapsulation): EncapsulationInterface
    {
        return IntersectionCalculation::getDifference($this, $encapsulation);
    }

    public function __clone()
    {
        foreach ($this->toArray() as $field => $value) {
            if (\is_object($value)) {
                $this->set($field, clone $value);
            }
        }
    }
}
