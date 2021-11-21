<?php

namespace Fastwf\Tests\Constraints\String;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\String\TimeFormat;

class TimeFormatTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\TimeFormat
     * @covers Fastwf\Constraint\Utils\Range
     */
    public function testValidate()
    {
        $constraint = new TimeFormat();

        $this->assertNull($constraint->validate(
            Node::from(['value' => '12:30:00']),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\TimeFormat
     */
    public function testValidateErrorFormat()
    {
        $constraint = new TimeFormat();

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => '12:30:000']),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\TimeFormat
     * @covers Fastwf\Constraint\Utils\Range
     */
    public function testValidateErrorRange()
    {
        $constraint = new TimeFormat();

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => '24:30:00']),
            $this->context,
        ));
    }

}
