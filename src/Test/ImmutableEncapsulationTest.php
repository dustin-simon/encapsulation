<?php

namespace Dustin\Encapsulation\Test;

use Dustin\Encapsulation\Encapsulation;
use Dustin\Encapsulation\Exception\EncapsulationImmutableException;
use Dustin\Encapsulation\ImmutableEncapsulation;
use Dustin\Encapsulation\ImmutableTrait;
use Dustin\Encapsulation\MutableInterface;
use Dustin\Encapsulation\PropertyEncapsulation;
use PHPUnit\Framework\TestCase;

class MyEncapsulation extends PropertyEncapsulation
{
    use ImmutableTrait;
    protected $foo;
}

class ImmutableEncapsulationTest extends TestCase
{
    public function testImmutableEncapsulation()
    {
        $encapsulation = new ImmutableEncapsulation(['foo' => 'bar']);

        $this->expectException(EncapsulationImmutableException::class);
        $encapsulation->set('hello', 'world');
    }

    public function testImmutableTrait()
    {
        $encapsulation = new MyEncapsulation(['foo' => 'bar']);

        $this->expectException(EncapsulationImmutableException::class);

        $encapsulation->set('foo', 'barBar');
    }

    public function testImmutableInterface()
    {
        $mutableEncapsulation = new Encapsulation();
        $immutableEncapsulation1 = new ImmutableEncapsulation();
        $immutableEncapsulation2 = new MyEncapsulation();

        $this->assertTrue($mutableEncapsulation instanceof MutableInterface);
        $this->assertTrue($mutableEncapsulation->isMutable());

        $this->assertTrue($immutableEncapsulation1 instanceof MutableInterface);
        $this->assertFalse($immutableEncapsulation1->isMutable());

        $this->assertTrue($immutableEncapsulation2 instanceof MutableInterface);
        $this->assertFalse($immutableEncapsulation2->isMutable());
    }
}
