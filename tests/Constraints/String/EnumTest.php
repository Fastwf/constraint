<?php

namespace Fastwf\Tests\Constraints\String;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Constraints\String\Enum;
use Fastwf\Tests\Constraints\ConstraintTestCase;

class EnumTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Enum
     */
    public function testValidate()
    {
        $constraint = new Enum(['one', 'two']);

        $this->assertNull($constraint->validate(Node::from(['value' => 'one']), $this->context));
    }
    
    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Enum
     */
    public function testValidateErrors()
    {
        $constraint = new Enum(['one', 'two']);

        $this->assertNotNull($constraint->validate(Node::from(['value' => 'three']), $this->context));
    }

}