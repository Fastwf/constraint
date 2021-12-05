<?php

namespace Fastwf\Tests\Constraints\String;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\String\NotBlank;

class NotBlankTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\Blank
     * @covers Fastwf\Constraint\Constraints\String\NotBlank
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testValidate()
    {
        $constraint = new NotBlank();

        $this->assertNull($constraint->validate(Node::from(['value' => '  hello world!  ']), $this->context));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\Blank
     * @covers Fastwf\Constraint\Constraints\String\NotBlank
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testValidateError()
    {
        $constraint = new NotBlank();

        $this->assertNotNull($constraint->validate(Node::from(['value' => "  \t\r\n  "]), $this->context));
    }

}
