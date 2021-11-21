<?php

namespace Fastwf\Tests\Constraints\Type;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Type\StringType;

class StringTypeTest extends ConstraintTestCase
{
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testValidate()
    {
        $validator = new StringType();

        $this->assertNull($validator->validate(
            Node::from(['value' => 'test']),
            $this->context,
        ));
    }
    
    /**
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testValidateError()
    {
        $validator = new StringType();

        $this->assertNotNull($validator->validate(
            Node::from(['value' => 10]),
            $this->context,
        ));
    }

}
