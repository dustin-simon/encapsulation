<?php

namespace Dustin\Encapsulation\Exception;

use Dustin\Encapsulation\EncapsulationInterface;

class EncapsulationException extends \Exception
{
    public function __construct(
        private EncapsulationInterface $encapsulation,
        string $message = '', int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getEncapsulation(): EncapsulationInterface
    {
        return $this->encapsulation;
    }
}
