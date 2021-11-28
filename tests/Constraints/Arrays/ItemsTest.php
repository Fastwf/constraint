<?php

namespace Fastwf\Tests\Constraints\Arrays;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Constraints\Arrays\Items;
use Fastwf\Constraint\Constraints\Type\IntegerType;
use Fastwf\Tests\Constraints\ConstraintTestCase;

class ItemsTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Arrays\Items
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testValidate()
    {
        $constraint = new Items(new IntegerType());

        $this->assertNull($constraint->validate(Node::from(['value' => [1, 2, 3]]), $this->context));
    }
    
    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Arrays\Items
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testValidateErrors()
    {
        $constraint = new Items(new IntegerType());

        $violation = $constraint->validate(Node::from(['value' => [1, '2', '3']]), $this->context);
        $this->assertNotNull($violation);
        $this->assertEquals(2, count($violation->getChildren()));
    }

}