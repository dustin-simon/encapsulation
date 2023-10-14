<?php

namespace Dustin\Encapsulation\Exception;

use Dustin\Encapsulation\EncapsulationInterface;

class NotAllowedFieldException extends EncapsulationException
{
    public function __construct(
        EncapsulationInterface $encapsulation,
        private string $field
    ) {
        parent::__construct(
            $encapsulation,
            \sprintf("Field '%s' is not allowed in %s!", $field, \get_class($encapsulation))
        );
    }

    public function getField(): string
    {
        return $this->field;
    }
}
