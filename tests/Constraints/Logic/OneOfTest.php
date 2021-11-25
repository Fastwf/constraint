<?php

namespace Fastwf\Tests\Constraints\Logic;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Constraints\Logic\OneOf;
use Fastwf\Constraint\Constraints\String\Enum;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Type\DoubleType;
use Fastwf\Constraint\Constraints\Type\StringType;
use Fastwf\Constraint\Constraints\Type\IntegerType;

class OneOfTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Logic\OneOf
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidate()
    {
        $constraint = new OneOf(new StringType(), new IntegerType());

        $this->assertNull($constraint->validate(Node::from(['value' => 'one']), $this->context));
    }
    
    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Logic\OneOf
     * @covers Fastwf\Constraint\Constraints\String\Enum
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateErrorsMore()
    {
        $constraint = new OneOf(new StringType(), new Enum(['one', 'two']), new IntegerType());

        $this->assertNotNull($constraint->validate(Node::from(['value' => 'one']), $this->context));
    }
    
    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Logic\OneOf
     * @covers Fastwf\Constraint\Constraints\String\Enum
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     * @covers Fastwf\Constraint\Constraints\Type\DoubleType
     */
    public function testValidateErrorsNone()
    {
        $constraint = new OneOf(new StringType(), new DoubleType(), new IntegerType());

        $this->assertNotNull($constraint->validate(Node::from(['value' => false]), $this->context));
    }

}
