<?php

namespace Fastwf\Tests\Data;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Data\Node;

class NodeTest extends TestCase 
{

    private const VALUE = "foo";

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testConstructorStandard()
    {
        $node = new Node(["value" => self::VALUE]);

        $this->assertEquals(self::VALUE, $node->get());
        $this->assertTrue($node->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testConstructorIsDefinedIgnored()
    {
        $node = new Node(["value" => self::VALUE, "isDefined" => false]);

        $this->assertEquals(self::VALUE, $node->get());
        $this->assertTrue($node->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testConstructorValueNull()
    {
        $node = new Node(["value" => null]);

        $this->assertEquals(null, $node->get());
        $this->assertTrue($node->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testConstructorValueNullDefined()
    {
        $node = new Node(["value" => null, "isDefined" => true]);

        $this->assertEquals(null, $node->get());
        $this->assertTrue($node->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testConstructorValueNullNotDefined()
    {
        $node = new Node(["value" => null, "isDefined" => false]);

        $this->assertEquals(null, $node->get());
        $this->assertFalse($node->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testConstructorNoValue()
    {
        $node = new Node();

        $this->assertEquals(null, $node->get());
        $this->assertFalse($node->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function test__get()
    {
        $this->assertFalse((new Node())->any->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function test__set()
    {
        $node = new Node(['value' => self::VALUE]);

        $node->any = self::VALUE;

        $this->assertFalse($node->any->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function test__isset()
    {
        $node = new Node(['value' => self::VALUE]);

        $this->assertFalse(isset($node->any));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testFrom()
    {
        $this->assertFalse(Node::from()->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testFromValue()
    {
        $this->assertEquals(self::VALUE, Node::from(['value' => self::VALUE])->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testGetIterator()
    {
        $iterator = Node::from(['value' => self::VALUE])->getIterator();
        $iterator->rewind();

        // For simple values, it return an empty iterator
        $this->assertFalse($iterator->valid());
    }

}
