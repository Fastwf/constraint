<?php

namespace Fastwf\Tests\Reflection;

use Fastwf\Tests\Model\Data;
use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Exceptions\NodeException;
use Fastwf\Constraint\Reflection\UndefinedProperty;

class UndefinedPropertyTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Reflection\UndefinedProperty
     */
    public function testGet()
    {
        $property = new UndefinedProperty();

        $this->assertFalse($property->get(null)->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Reflection\UndefinedProperty
     */
    public function testSet()
    {
        $this->expectException(NodeException::class);

        $data = new Data();

        $property = new UndefinedProperty();
        $property->set($data, 'something');
    }

}
