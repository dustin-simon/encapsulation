<?php

namespace Dustin\Encapsulation\Exception;

use Dustin\Encapsulation\EncapsulationInterface;

class PropertyNotExistsException extends EncapsulationException
{
    public function __construct(
        EncapsulationInterface $encapsulation,
        private string $property
    ) {
        parent::__construct(
            $encapsulation,
            \sprintf("Property '%s' does not exist in %s", $property, \get_class($encapsulation))
        );
    }

    public function getProperty(): string
    {
        return $this->property;
    }
}
