<?php

namespace Fastwf\Tests\Api;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Api\ValidationContext;

class ValidationContextTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Api\ValidationContext
     */
    public function testGetters()
    {
        $root = Node::from(["value" => ['foo' => 'bar']]);

        $ctx = new ValidationContext($root, $root);

        $this->assertEquals($root, $ctx->getRoot());
        $this->assertEquals($root, $ctx->getParent());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Api\ValidationContext
     */
    public function testGetSubContext()
    {
        $root = Node::from(["value" => ['foo' => 'bar']]);

        $ctx = new ValidationContext($root, null);
        $ctx = $ctx->getSubContext($root);

        $this->assertEquals($root, $ctx->getRoot());
        $this->assertEquals($root, $ctx->getParent());
    }

    /**
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testViolationFromNull()
    {
        $ctx = new ValidationContext(null, null);

        $this->assertEquals(1, \count($ctx->violation(null, 'any', [])->getViolations()));
    }

    /**
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testViolationChained()
    {
        $ctx = new ValidationContext(null, null);

        $expected = $ctx->violation(null, 'any', []);
        $actual = $ctx->violation(null, 'other', [], $expected);

        $this->assertEquals($expected, $actual);
        $this->assertEquals(2, \count($actual->getViolations()));
    }

}