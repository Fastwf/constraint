<?php

namespace Fastwf\Tests\Constraints\Logic;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Constraints\Logic\AllOf;
use Fastwf\Constraint\Constraints\String\Enum;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Type\StringType;

class AllOfTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Logic\AllOf
     * @covers Fastwf\Constraint\Constraints\String\Enum
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     */
    public function testValidate()
    {
        $constraint = new AllOf(new StringType(), new Enum(['one', 'two']));

        $this->assertNull($constraint->validate(Node::from(['value' => 'one']), $this->context));
    }
    
    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Logic\AllOf
     * @covers Fastwf\Constraint\Constraints\String\Enum
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     */
    public function testValidateErrors()
    {
        $constraint = new AllOf(new StringType(), new Enum(['one', 'two']));

        $this->assertNotNull($constraint->validate(Node::from(['value' => 'three']), $this->context));
    }

}
