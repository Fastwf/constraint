<?php

namespace Fastwf\Tests\Constraints\Arrays;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Arrays\MinItems;

class MinItemsTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Arrays\Count
     * @covers Fastwf\Constraint\Constraints\Arrays\MinItems
     */
    public function testValidate()
    {
        $constraint = new MinItems(5);

        $this->assertNull($constraint->validate(
            Node::from(['value' => [1, 2, 3, 4, 5]]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Arrays\Count
     * @covers Fastwf\Constraint\Constraints\Arrays\MinItems
     */
    public function testValidateError()
    {
        $constraint = new MinItems(1);

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => []]),
            $this->context,
        ));
    }

}
