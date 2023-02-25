<?php

namespace Dustin\Encapsulation;

class ObjectMapping extends AbstractObjectMapping
{
    private $objectClass = null;

    public function __construct(string $class)
    {
        $this->objectClass = $class;
    }

    protected function getType(): string
    {
        return $this->objectClass;
    }
}
