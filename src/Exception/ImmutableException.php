<?php

namespace Dustin\Encapsulation\Exception;

use Dustin\Encapsulation\Container;
use Dustin\Encapsulation\EncapsulationInterface;

class ImmutableException extends \Exception
{
    public function __construct(EncapsulationInterface|Container $encapsulationOrContainer)
    {
        parent::__construct(
            sprintf('Object of class %s is immutable.', get_class($encapsulationOrContainer))
        );
    }
}
