<?php

namespace Dustin\Encapsulation\Test;

use Dustin\Encapsulation\Exception\NotUnsettableException;
use Dustin\Encapsulation\Exception\PropertyNotExistsException;
use Dustin\Encapsulation\Exception\StaticPropertyException;
use Dustin\Encapsulation\PropertyEncapsulation;
use PHPUnit\Framework\TestCase;

class MyEncapsulation extends PropertyEncapsulation
{
    protected static $fruits;

    protected $foo;

    protected string $bar;

    protected string $hello = 'world';

    protected array $myList = [];

    public function getFoo()
    {
        return $this->foo;
    }

    public function setFoo($foo)
    {
        $this->foo = $foo;
    }

    public function getBar()
    {
        return $this->bar;
    }

    public function setBar($bar)
    {
        $this->bar = $bar;
    }

    public function getHello()
    {
        return $this->hello;
    }

    public function setHello($hello)
    {
        $this->hello = $hello;
    }

    public function getMyList()
    {
        return $this->myList;
    }

    public function setMyList($myList)
    {
        $this->myList = $myList;
    }
}

class PropertyEncapsulationTest extends TestCase
{
    public function testBasics()
    {
        $encapsulation = new MyEncapsulation(['foo' => 'foo']);
        $encapsulation->set('bar', 'bar');

        $this->assertSame(
            $encapsulation->toArray(),
            [
                'foo' => 'foo',
                'bar' => 'bar',
                'hello' => 'world',
                'myList' => [],
            ]
        );
    }

    public function testPropertyType()
    {
        $encapsulation = new MyEncapsulation();

        $this->expectException(\TypeError::class);

        $encapsulation->set('bar', [1234]);
    }

    public function testMissingProperty()
    {
        $encapsulation = new MyEncapsulation();

        $this->expectException(PropertyNotExistsException::class);

        $encapsulation->set('movieList', ['Rocky', 'Rambo']);
    }

    public function testStaticProperty()
    {
        $encapsulation = new MyEncapsulation();

        $this->expectException(StaticPropertyException::class);

        $encapsulation->set('fruits', ['kiwi', 'carambola']);
    }

    public function testUnsettable()
    {
        $encapsulation = new MyEncapsulation();

        $this->expectException(NotUnsettableException::class);

        $encapsulation->unset('hello');
    }

    public function testGetFields()
    {
        $encapsulation = new MyEncapsulation();

        $this->assertSame(
            $encapsulation->getFields(),
            ['foo', 'bar', 'hello', 'myList']
        );
    }
}
