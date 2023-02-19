<?php

namespace Dustin\Encapsulation\Test;

use Dustin\Encapsulation\Container;
use Dustin\Encapsulation\Encapsulation;
use Dustin\Encapsulation\NestedEncapsulation;
use PHPUnit\Framework\TestCase;

class NestedEncapsulationContainer extends Container
{
    protected function getAllowedClass(): ?string
    {
        return NestedEncapsulation::class;
    }
}

class ContainerTest extends TestCase
{
    public function testInitialization()
    {
        $container = new Container(['apple', 'kiwi', 'carambola']);

        $this->assertSame(
            $container->toArray(),
            ['apple', 'kiwi', 'carambola']
        );
    }

    public function testBasics()
    {
        $container = new Container(['apple', 'kiwi']);
        $container->add('carambola');

        $this->assertSame(
            $container->toArray(),
            ['apple', 'kiwi', 'carambola']
        );

        $this->assertSame($container->getAt(1), 'kiwi');
        $this->assertSame(count($container), 3);
        $this->assertFalse($container->isEmpty());

        $container->clear();
        $this->assertTrue($container->isEmpty());
    }

    public function testIteration()
    {
        $heroes = ['Batman', 'Superman', 'Flash'];
        $container = new Container($heroes);

        foreach ($container as $hero) {
            $this->assertTrue(\in_array($hero, $heroes));
        }
    }

    public function testSerialization()
    {
        $container = new Container(['foo', 'bar']);
        $serialized = serialize($container);

        $newContainer = unserialize($serialized);

        $this->assertSame(
            $container->toArray(),
            $newContainer->toArray()
        );

        $json = json_encode($container);
        $data = json_decode($json);

        $this->assertSame(
            $data,
            $container->toArray()
        );
    }

    public function testAllowedClass()
    {
        $container = new NestedEncapsulationContainer([new NestedEncapsulation()]);

        $this->expectException(\InvalidArgumentException::class);

        $container->add(new Encapsulation());
    }

    public function testRemoveAt()
    {
        $container = new Container(['Iron Man', 'Captain America', 'Thor']);
        $container->removeAt(1);

        $this->assertSame(
            $container->toArray(),
            ['Iron Man', 'Thor']
        );
    }
}
