<?php

namespace Fastwf\Tests\Constraints\Type;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Type\BooleanType;

class BooleanTypeTest extends ConstraintTestCase
{
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\BooleanType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testValidateTrue()
    {
        $validator = new BooleanType();

        $this->assertNull($validator->validate(
            Node::from(['value' => true]),
            $this->context,
        ));
    }
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\BooleanType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testValidateFalse()
    {
        $validator = new BooleanType();

        $this->assertNull($validator->validate(
            Node::from(['value' => false]),
            $this->context,
        ));
    }
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\BooleanType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testValidateError()
    {
        $validator = new BooleanType();

        $this->assertNotNull($validator->validate(
            Node::from(['value' => 'true']),
            $this->context,
        ));
    }

}
