<?php

namespace Fastwf\Tests\Constraints\Type;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Type\IntegerType;

class IntegerTypeTest extends ConstraintTestCase
{
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testValidate()
    {
        $validator = new IntegerType();

        $this->assertNull($validator->validate(
            Node::from(['value' => 10]),
            $this->context,
        ));
    }
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testValidateError()
    {
        $validator = new IntegerType();

        $this->assertNotNull($validator->validate(
            Node::from(['value' => 'test']),
            $this->context,
        ));
    }

}
