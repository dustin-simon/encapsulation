<?php

namespace Dustin\Encapsulation\Exception;

class UncomparableException extends \Exception
{
    public function __construct(mixed $value)
    {
        parent::__construct(sprintf('%s is not comparable for intersection calculation', get_debug_type($value)));
    }
}
