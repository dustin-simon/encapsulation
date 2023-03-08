<?php

namespace Dustin\Encapsulation\Test;

use Dustin\Encapsulation\Exception\EncapsulationImmutableException;
use Dustin\Encapsulation\ImmutableEncapsulation;
use Dustin\Encapsulation\ImmutableTrait;
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
}
