<?php

namespace Fastwf\Tests\Constraints\Logic;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Constraints\Logic\AnyOf;
use Fastwf\Constraint\Constraints\String\Enum;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Type\StringType;
use Fastwf\Constraint\Constraints\Type\IntegerType;

class AnyOfTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Logic\AnyOf
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidate()
    {
        $constraint = new AnyOf(new StringType(), new IntegerType());

        $this->assertNull($constraint->validate(Node::from(['value' => 'one']), $this->context));
    }
    
    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Logic\AnyOf
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateErrors()
    {
        $constraint = new AnyOf(new StringType(), new IntegerType());

        $this->assertNotNull($constraint->validate(Node::from(['value' => true]), $this->context));
    }

}
