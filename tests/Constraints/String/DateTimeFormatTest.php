<?php

namespace Fastwf\Tests\Constraints\String;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\String\DateTimeFormat;

class DateTimeFormatTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\DateTimeFormat
     * @covers Fastwf\Constraint\Utils\Range
     */
    public function testValidateUtc()
    {
        $constraint = new DateTimeFormat();

        $this->assertNull($constraint->validate(
            Node::from(['value' => '2021-01-01T12:30:00Z']),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\DateTimeFormat
     * @covers Fastwf\Constraint\Utils\Range
     */
    public function testValidateOffset()
    {
        $constraint = new DateTimeFormat();

        $this->assertNull($constraint->validate(
            Node::from(['value' => '2021-01-01T12:30:00+01:00']),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\DateTimeFormat
     */
    public function testValidateErrorFormat()
    {
        $constraint = new DateTimeFormat();

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => '20210101T123000Z']),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\DateTimeFormat
     */
    public function testValidateErrorDateTime()
    {
        $constraint = new DateTimeFormat();

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => '2021-13-32T12:30:00Z']),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\DateTimeFormat
     * @covers Fastwf\Constraint\Utils\Range
     */
    public function testValidateErrorOffset()
    {
        $constraint = new DateTimeFormat();

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => '2021-01-01T12:30:00.000+24:00']),
            $this->context,
        ));
    }

}
