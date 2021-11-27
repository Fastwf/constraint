<?php

namespace Fastwf\Tests\Constraints\Number;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Constraints\Chain;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Number\Minimum;
use Fastwf\Constraint\Constraints\Type\IntegerType;
use Fastwf\Constraint\Constraints\Number\MultipleOf;

class ChainTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\Number\MultipleOf
     * @covers Fastwf\Constraint\Constraints\Number\Minimum
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateStopFirst()
    {
        $constraint = new Chain(true, new IntegerType(), new Minimum(0), new MultipleOf(10));

        $this->assertNull($constraint->validate(
            Node::from(['value' => 100]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\Number\MultipleOf
     * @covers Fastwf\Constraint\Constraints\Number\Minimum
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateAll()
    {
        $constraint = new Chain(false, new IntegerType(), new Minimum(0), new MultipleOf(10));

        $this->assertNull($constraint->validate(
            Node::from(['value' => 100]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\Number\MultipleOf
     * @covers Fastwf\Constraint\Constraints\Number\Minimum
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateStopFirstError()
    {
        $constraint = new Chain(true, new IntegerType(), new Minimum(30), new MultipleOf(15));

        $this->assertEquals(
            1,
            count(
                $constraint->validate(
                    Node::from(['value' => 10]),
                    $this->context,
                )->getViolations()
            )
        );
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\Number\MultipleOf
     * @covers Fastwf\Constraint\Constraints\Number\Minimum
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateAllError()
    {
        $constraint = new Chain(false, new IntegerType(), new Minimum(30), new MultipleOf(15));

        $this->assertEquals(
            2,
            count(
                $constraint->validate(
                    Node::from(['value' => 10]),
                    $this->context,
                )->getViolations()
            )
        );
    }

}
