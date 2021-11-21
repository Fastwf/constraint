<?php

namespace Fastwf\Tests\Constraints\Type;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Type\ObjectType;

class ObjectTypeTest extends ConstraintTestCase
{
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ObjectType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     */
    public function testValidateEmpty()
    {
        $validator = new ObjectType();

        $this->assertNull($validator->validate(
            Node::from(['value' => []]),
            $this->context,
        ));
    }
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ObjectType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     */
    public function testValidateNotEmpty()
    {
        $validator = new ObjectType();

        $this->assertNull($validator->validate(
            Node::from(['value' => ["foo" => "bar"]]),
            $this->context,
        ));
    }
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ObjectType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     */
    public function testValidateClass()
    {
        $validator = new ObjectType();

        $this->assertNull($validator->validate(
            Node::from(['value' => new \StdClass()]),
            $this->context,
        ));
    }
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ObjectType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testValidateErrorObject()
    {
        $validator = new ObjectType();

        $this->assertNotNull($validator->validate(
            Node::from(['value' => ['first', 'second']]),
            $this->context,
        ));
    }
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ObjectType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testValidateError()
    {
        $validator = new ObjectType();

        $this->assertNotNull($validator->validate(
            Node::from(['value' => 'test']),
            $this->context,
        ));
    }

}
