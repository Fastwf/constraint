<?php

namespace Fastwf\Tests\Constraints;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Required;
use Fastwf\Constraint\Constraints\Type\IntegerType;

class RequiredTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Required
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateOptional()
    {
        $subConstraint = new IntegerType();
        $constraint = new Required(false, $subConstraint);

        $this->assertNull($constraint->validate(
            new Node(),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Required
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateRequired()
    {
        $subConstraint = new IntegerType();
        $constraint = new Required(true, $subConstraint);

        $this->assertNull($constraint->validate(
            Node::from(['value' => 10]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Required
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateOnlyRequired()
    {
        $constraint = new Required(true);

        $this->assertNull($constraint->validate(
            Node::from(['value' => "any"]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Required
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateOptionalError()
    {
        $subConstraint = new IntegerType();
        $constraint = new Required(false, $subConstraint);

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => null]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Required
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateRequiredError()
    {
        $subConstraint = new IntegerType();
        $constraint = new Required(true, $subConstraint);

        $this->assertNotNull($constraint->validate(
            new Node(),
            $this->context,
        ));
    }

}
