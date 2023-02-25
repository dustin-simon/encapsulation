<?php

namespace Dustin\Encapsulation;

class ObjectMapping extends AbstractObjectMapping
{
    private $objectClass = null;

    public function __construct(string $class)
    {
        $this->objectClass = $class;
    }

    public function __serialize(): array
    {
        return serialize([
            'objectClass' => $this->objectClass,
            'data' => $this->toArray(),
        ]);
    }

    public function __unserialize(array $data): void
    {
        $data = unserialize($data);

        $this->objectClass = $data['objectClass'];
        $this->setList($data['data']);
    }

    protected function getType(): string
    {
        return $this->objectClass;
    }
}
