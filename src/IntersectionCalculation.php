<?php

namespace Dustin\Encapsulation;

use Dustin\Encapsulation\Exception\UncomparableException;

class IntersectionCalculation
{
    public static function getFieldIntersection(EncapsulationInterface $a, EncapsulationInterface $b): array
    {
        return array_values(
            \array_intersect(
                array_values($a->getFields()),
                array_values($b->getFields())
            )
        );
    }

    public static function getFieldDifference(EncapsulationInterface $a, EncapsulationInterface $b): array
    {
        return array_values(
            \array_diff(
                array_values($a->getFields()),
                array_values($b->getFields())
            )
        );
    }

    public static function getIntersection(AbstractEncapsulation $a, AbstractEncapsulation $b): EncapsulationInterface
    {
        $intersectionFields = static::getFieldIntersection($a, $b);
        $intersection = new NestedEncapsulation();

        /** @var string $field */
        foreach ($intersectionFields as $field) {
            $value = $a->get($field);
            $compareValue = $b->get($field);

            if (!static::isComparable($value)) {
                throw new UncomparableException($value);
            }

            if (!static::isComparable($compareValue)) {
                throw new UncomparableException($compareValue);
            }

            if (\is_scalar($value) || $value === null) {
                if ($value === $compareValue) {
                    $intersection->set($field, $value);
                }

                continue;
            }

            if ($compareValue === null) {
                continue;
            }

            $value = is_array($value) ? new Encapsulation($value) : $value;
            $compareValue = is_array($compareValue) ? new Encapsulation($compareValue) : $compareValue;
            $intersectedData = static::getIntersection($value, $compareValue);

            if (!empty($intersectedData->toArray())) {
                $intersection->set($field, $intersectedData);
            }
        }

        return $intersection;
    }

    public function getDifference(AbstractEncapsulation $a, AbstractEncapsulation $b): EncapsulationInterface
    {
        $difference = new NestedEncapsulation();

        /** @var string $field */
        foreach ($a->getFields() as $field) {
            $value = $a->get($field);

            if (!static::isComparable($value)) {
                throw new UncomparableException($value);
            }

            if (!$b->has($field)) {
                if (is_scalar($value) || $value === null) {
                    $difference->set($field, $value);
                    continue;
                }

                if (\is_object($value)) {
                    $difference->set($field, clone $value);
                    continue;
                }

                // $value must be array
                // Creating the difference from an empty object converts array into Encapsulations and clones objects
                $difference->set($field, static::getDifference(new Encapsulation($value), new Encapsulation()));
                continue;
            }

            $compareValue = $b->get($field);

            if (!static::isComparable($compareValue)) {
                throw new UncomparableException($compareValue);
            }

            if (\is_scalar($value) || $value == null) {
                if ($value !== $compareValue) {
                    $difference->set($field, $value);
                }

                continue;
            }

            $value = is_array($value) ? new Encapsulation($value) : $value;
            $compareData = is_array($compareValue) || $compareValue === null ? new Encapsulation((array) $compareValue) : $compareValue;
            $differencedData = static::getDifference($value, $compareData);

            if (!empty($differencedData->toArray()) || $compareValue === null) {
                $difference->set($field, $differencedData);
            }
        }

        return $difference;
    }

    public static function isComparable($value): bool
    {
        return !(
            \is_resource($value) ||
            (is_object($value) && !($value instanceof AbstractEncapsulation))
        );
    }
}
