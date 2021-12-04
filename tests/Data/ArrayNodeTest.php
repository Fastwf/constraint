<?php

namespace Fastwf\Tests\Data;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Data\ArrayNode;

class ArrayNodeTest extends TestCase
{

    private const VALUE = ["foo" => "bar"];
    
    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     */
    public function test__get()
    {
        $node = new ArrayNode(['value' => self::VALUE]);

        $this->assertEquals("bar", $node->foo->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     */
    public function test__getUndefined()
    {
        $node = new ArrayNode(['value' => self::VALUE]);

        $this->assertFalse($node->bar->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     */
    public function test__set()
    {
        $node = new ArrayNode(['value' => self::VALUE]);
        $node->foo = "bar2";

        $this->assertEquals("bar2", $node->foo->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     */
    public function test__setNewProperty()
    {
        $node = new ArrayNode(['value' => self::VALUE]);
        $node->bar = "foo";

        $this->assertEquals("foo", $node->bar->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     */
    public function test__isset()
    {
        $node = new ArrayNode(['value' => self::VALUE]);

        $this->assertTrue(isset($node->foo));
        $this->assertFalse(isset($node->bar));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     */
    public function test__fromArray()
    {
        $node = Node::from(['value' => self::VALUE]);

        $this->assertEquals("bar", $node->foo->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testGetIterator()
    {
        // Reconstitute the array using foreach operation
        $array = [];
        foreach (Node::from(['value' => self::VALUE]) as $index => $value)
        {
            $array[$index] = $value;
        }

        // Check the array has the key and the value is wrapped in Node
        $this->assertTrue($array['foo'] instanceof Node);
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testGetBuiltIn()
    {
        $array = [['name' => 'foo', 'age' => 25]];
        $node = Node::from(['value' => $array]);

        $this->assertEquals($array, $node->getBuiltIn());
    }

}
