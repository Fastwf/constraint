<?php

namespace Fastwf\Tests\Constraints\String;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\String\HostnameFormat;

class HostnameFormatTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\HostnameFormat
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testValidate()
    {
        $constraint = new HostnameFormat();

        $this->assertNull($constraint->validate(Node::from(['value' => 'test.fr']), $this->context));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\HostnameFormat
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testValidateError()
    {
        $constraint = new HostnameFormat();

        $this->assertNotNull($constraint->validate(Node::from(['value' => '-test.fr']), $this->context));
    }

}
