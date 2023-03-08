<?php

namespace Dustin\Encapsulation\Exception;

use Dustin\Encapsulation\EncapsulationInterface;

class EncapsulationImmutableException extends EncapsulationException
{
    public function __construct(EncapsulationInterface $encapsulation)
    {
        parent::__construct(
            $encapsulation,
            sprintf('Encapsulation of class %s is immutable.', get_class($encapsulation))
        );
    }
}
