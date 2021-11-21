<?php

namespace Fastwf\Tests\Constraints\String;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\String\DateFormat;

class DateFormatTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\DateFormat
     */
    public function testValidate()
    {
        $constraint = new DateFormat();

        $this->assertNull($constraint->validate(
            Node::from(['value' => '2021-01-01']),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\DateFormat
     */
    public function testValidateError()
    {
        $constraint = new DateFormat();

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => '2021-13-32']),
            $this->context,
        ));
    }

}
