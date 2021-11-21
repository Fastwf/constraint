<?php

namespace Fastwf\Tests\Constraints\String;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\String\IPv6Format;

class IPv6FormatTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\IPv6Format
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testValidate()
    {
        $constraint = new IPv6Format();

        $this->assertNull($constraint->validate(Node::from(['value' => '::1']), $this->context));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\IPv6Format
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testValidateError()
    {
        $constraint = new IPv6Format();

        $this->assertNotNull($constraint->validate(Node::from(['value' => '127.0.0.1']), $this->context));
    }

}
