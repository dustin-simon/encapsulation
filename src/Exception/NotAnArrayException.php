<?php

namespace Dustin\Encapsulation\Exception;

use Dustin\Encapsulation\EncapsulationInterface;

class NotAnArrayException extends EncapsulationException
{
    public function __construct(
        EncapsulationInterface $encapsulation,
        private string $field
    ) {
        parent::__construct(
            $encapsulation,
            \sprintf("Field '%s' must be array or container to add values to it.", $field)
        );
    }

    public function getField(): string
    {
        return $this->field;
    }
}
