<?php

namespace Fastwf\Tests\Constraints\Logic;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Constraints\Logic\Not;
use Fastwf\Constraint\Constraints\String\Enum;
use Fastwf\Tests\Constraints\ConstraintTestCase;

class NotTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Logic\Not
     * @covers Fastwf\Constraint\Constraints\String\Enum
     */
    public function testValidate()
    {
        $constraint = new Not(new Enum(['one', 'two']));

        $this->assertNull($constraint->validate(Node::from(['value' => 'three']), $this->context));
    }
    
    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Logic\Not
     * @covers Fastwf\Constraint\Constraints\String\Enum
     */
    public function testValidateErrors()
    {
        $constraint = new Not(new Enum(['one', 'two']));

        $this->assertNotNull($constraint->validate(Node::from(['value' => 'one']), $this->context));
    }

}
