<?php

namespace Fastwf\Tests\Constraints\Number;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Number\Minimum;

class MinimumTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Number\Minimum
     */
    public function testValidate()
    {
        $constraint = new Minimum(10);

        $this->assertNull($constraint->validate(
            Node::from(['value' => 10]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Number\Minimum
     */
    public function testValidateError()
    {
        $constraint = new Minimum(10);

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => 5]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Number\Minimum
     */
    public function testValidateExclusiveError()
    {
        $constraint = new Minimum(10, true);

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => 10]),
            $this->context,
        ));
    }

}
