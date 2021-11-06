<?php

namespace Fastwf\Tests\Reflection;

use Fastwf\Tests\Model\Data;
use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Reflection\StdProperty;
use Fastwf\Constraint\Exceptions\NodeException;

class StdPropertyTest extends TestCase
{

    private $reflection;

    private $data;

    protected function setUp(): void
    {
        $data = new Data();
        $data->name = 'child';
        $data->setParent('parent');
        $data->setAlive(true);
        $data->setRoot(true);
        $data->setChildren(true);

        $this->data = $data;

        $this->reflection = new \ReflectionClass($data);
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\Method
     */
    public function testGetName()
    {
        $prop = new StdProperty($this->reflection, $this->reflection->getProperty('isAlive'));

        $this->assertTrue($prop->get($this->data)->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\Method
     */
    public function testGetGet()
    {
        $prop = new StdProperty($this->reflection, $this->reflection->getProperty('parent'));

        $this->assertEquals('parent', $prop->get($this->data)->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\Method
     */
    public function testGetIs()
    {
        $prop = new StdProperty($this->reflection, $this->reflection->getProperty('root'));

        $this->assertTrue($prop->get($this->data)->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\Method
     */
    public function testGetHas()
    {
        $prop = new StdProperty($this->reflection, $this->reflection->getProperty('children'));

        $this->assertTrue($prop->get($this->data)->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\Method
     */
    public function testSet()
    {
        $prop = new StdProperty($this->reflection, $this->reflection->getProperty('root'));
        
        $this->data->setRoot(false);
        $prop->set($this->data, true);

        $this->assertTrue($prop->get($this->data)->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\UndefinedGetterMethod
     */
    public function testGetUndefined()
    {
        // The property exists but there are no getter to access to the value
        $prop = new StdProperty($this->reflection, $this->reflection->getProperty('name'));

        $this->assertFalse($prop->get($this->data)->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\UndefinedSetterMethod
     */
    public function testSetUndefined()
    {
        $this->expectException(NodeException::class);

        // The property exists but there are no setter to access to the value
        $prop = new StdProperty($this->reflection, $this->reflection->getProperty('name'));
        $prop->set($this->data, 'other');
    }

}