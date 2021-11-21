<?php

namespace Fastwf\Tests\Constraints\Type;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Type\ArrayType;

class ArrayTypeTest extends ConstraintTestCase
{
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     */
    public function testValidateEmpty()
    {
        $validator = new ArrayType();

        $this->assertNull($validator->validate(
            Node::from(['value' => []]),
            $this->context,
        ));
    }
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     */
    public function testValidateNotEmpty()
    {
        $validator = new ArrayType();

        $this->assertNull($validator->validate(
            Node::from(['value' => ["first", "second"]]),
            $this->context,
        ));
    }
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testValidateErrorObject()
    {
        $validator = new ArrayType();

        $this->assertNotNull($validator->validate(
            Node::from(['value' => ['foo' => 'bar']]),
            $this->context,
        ));
    }
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testValidateError()
    {
        $validator = new ArrayType();

        $this->assertNotNull($validator->validate(
            Node::from(['value' => 'test']),
            $this->context,
        ));
    }

}
