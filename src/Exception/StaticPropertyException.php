<?php

namespace Dustin\Encapsulation\Exception;

use Dustin\Encapsulation\EncapsulationInterface;

class StaticPropertyException extends EncapsulationException
{
    public function __construct(EncapsulationInterface $encapsulation, string $property)
    {
        parent::__construct(
            $encapsulation,
            \sprintf("Property '%s' is static and cannot be handled by encapsulations.", $property)
        );
    }
}
