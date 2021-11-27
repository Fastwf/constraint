<?php

namespace Fastwf\Tests\Constraints\Number;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Number\MultipleOf;

class MultipleOfTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Number\MultipleOf
     */
    public function testValidate()
    {
        $constraint = new MultipleOf(10);

        $this->assertNull($constraint->validate(
            Node::from(['value' => 100]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Number\MultipleOf
     */
    public function testValidateDouble()
    {
        $constraint = new MultipleOf(2.5);

        $this->assertNull($constraint->validate(
            Node::from(['value' => 17.5]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Number\MultipleOf
     */
    public function testValidateError()
    {
        $constraint = new MultipleOf(3);

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => 10]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Number\MultipleOf
     */
    public function testValidateDoubleError()
    {
        $constraint = new MultipleOf(99.99);

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => 100]),
            $this->context,
        ));
    }

}
