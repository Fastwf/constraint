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

        $this->assertEquals(self::VALUE, $node->getValue());
        $this->assertTrue($node->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testConstructorIsDefinedIgnored()
    {
        $node = new Node(["value" => self::VALUE, "isDefined" => false]);

        $this->assertEquals(self::VALUE, $node->getValue());
        $this->assertTrue($node->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testConstructorValueNull()
    {
        $node = new Node(["value" => null]);

        $this->assertEquals(null, $node->getValue());
        $this->assertTrue($node->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testConstructorValueNullDefined()
    {
        $node = new Node(["value" => null, "isDefined" => true]);

        $this->assertEquals(null, $node->getValue());
        $this->assertTrue($node->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testConstructorValueNullNotDefined()
    {
        $node = new Node(["value" => null, "isDefined" => false]);

        $this->assertEquals(null, $node->getValue());
        $this->assertFalse($node->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testConstructorNoValue()
    {
        $node = new Node();

        $this->assertEquals(null, $node->getValue());
        $this->assertFalse($node->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     */
    public function test__get()
    {
        $this->assertFalse((new Node())->any->isDefined());
    }

}
