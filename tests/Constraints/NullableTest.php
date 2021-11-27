<?php

namespace Fastwf\Tests\Constraints\Number;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Nullable;
use Fastwf\Constraint\Constraints\Type\IntegerType;

class NullableTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateNotNull()
    {
        $constraint = new Nullable(true, new IntegerType());

        $this->assertNull($constraint->validate(
            Node::from(['value' => 100]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateNull()
    {
        $constraint = new Nullable(true, new IntegerType());

        $this->assertNull($constraint->validate(
            Node::from(['value' => null]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateError()
    {
        $constraint = new Nullable(false, new IntegerType());

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => null]),
            $this->context,
        ));
    }

}
