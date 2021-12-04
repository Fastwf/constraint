<?php

namespace Fastwf\Tests\Constraints\Arrays;

use Fastwf\Tests\Model\Data;
use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Constraints\Arrays\Items;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Type\IntegerType;
use Fastwf\Constraint\Constraints\Arrays\UniqueItems;

class UniqueItemsTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Arrays\UniqueItems
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testValidate()
    {
        $constraint = new UniqueItems();

        $this->assertNull($constraint->validate(Node::from(['value' => [1, 2, 3]]), $this->context));
    }
    
    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Arrays\UniqueItems
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testValidateErrors()
    {
        $constraint = new UniqueItems();

        $this->assertNotNull($constraint->validate(Node::from(['value' => [1, 2, 2]]), $this->context));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Method
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\PublicProperty
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Arrays\UniqueItems
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     * @covers Fastwf\Constraint\Utils\Iterators\ObjectNodeIterator
     */
    public function testValidateObjects()
    {
        $constraint = new UniqueItems();

        $parent = new Data();
        $parent->setRoot(true);

        $child = new Data();
        $child->name = 'child';

        $parent->setChildren([$child]);

        $this->assertNull($constraint->validate(Node::from(['value' => [$parent, $child]]), $this->context));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Method
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\PublicProperty
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\Arrays\UniqueItems
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     * @covers Fastwf\Constraint\Utils\Iterators\ObjectNodeIterator
     */
    public function testValidateObjectsError()
    {
        $constraint = new UniqueItems();

        // Create 2 model using 2 object instances
        $first = new Data();
        $first->name = 'data';

        $second = new Data();
        $second->name = 'data';

        $this->assertNotNull($constraint->validate(Node::from(['value' => [$first, $second]]), $this->context));
    }

}
