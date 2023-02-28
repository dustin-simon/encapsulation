<?php

namespace Dustin\Encapsulation;

class ObjectMapping extends AbstractObjectMapping
{
    private $objectClass = null;

    public function __construct(array $data = [])
    {
        throw new \RuntimeException('ObjectMappings cannot be created via constructor. Use ObjectMapping::create instead');
    }

    public static function create(string $class): self
    {
        $mapping = (new \ReflectionClass(static::class))->newInstanceWithoutConstructor();
        $mapping->objectClass = $class;

        return $mapping;
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
