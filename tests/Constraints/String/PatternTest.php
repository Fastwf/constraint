<?php

namespace Fastwf\Tests\Constraints\String;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\String\Pattern;

class PatternTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Pattern
     */
    public function testValidate()
    {
        $constraint = new Pattern('\\d{5}');

        $this->assertNull($constraint->validate(Node::from(['value' => '12345']), $this->context));
    }
    
    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Pattern
     */
    public function testValidateErrors()
    {
        $constraint = new Pattern('\\d{5}');

        $this->assertNotNull($constraint->validate(Node::from(['value' => 'abcde']), $this->context));
    }

}
