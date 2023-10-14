<?php

namespace Dustin\Encapsulation\Exception;

use Dustin\Encapsulation\EncapsulationInterface;

class NotUnsettableException extends EncapsulationException
{
    public function __construct(
        EncapsulationInterface $encapsulation,
        private string $field
    ) {
        parent::__construct(
            $encapsulation,
            \sprintf("Field '%s' is not unsettable", $field)
        );
    }

    public function getField(): string
    {
        return $this->field;
    }
}
