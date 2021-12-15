<?php

namespace Fastwf\Tests\Constraints\Objects;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Constraints\Required;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\Objects\Schema;
use Fastwf\Constraint\Constraints\Type\ArrayType;
use Fastwf\Constraint\Constraints\Type\StringType;
use Fastwf\Constraint\Constraints\Type\IntegerType;

class SchemaTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     * @covers Fastwf\Constraint\Constraints\Objects\Schema
     * @covers Fastwf\Constraint\Api\ValidationContext
     */
    public function testValidate()
    {
        $constraint = new Schema([
            'properties' => [
                'name' => new StringType(),
                'age' => new IntegerType(),
            ],
            'minProperties' => 2,
            'maxProperties' => 2,
        ]);

        $this->assertNull($constraint->validate(
            Node::from(['value' => ['name' => 'foo', 'age' => 25]]),
            $this->context
        ));
    }
    
    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Constraints\Objects\Schema
     * @covers Fastwf\Constraint\Constraints\Required
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testValidateErrors()
    {
        $subConstraint = new ArrayType();
        $constraint = new Schema([
            'properties' => [
                'name' => new StringType(),
                'age' => new IntegerType(),
                'wallets' => new Required(true, $subConstraint),
            ],
            'minProperties' => 3,
            'maxProperties' => 3,
        ]);

        $violation = $constraint->validate(
            Node::from(['value' => ['name' => 'foo', 'age' => null]]),
            $this->context
        );

        $this->assertNotNull($violation);
        $this->assertTrue(isset($violation->getChildren()['wallets']));
        $this->assertTrue(isset($violation->getChildren()['age']));
        $this->assertEquals(1, count($violation->getViolations()));
    }
    
    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Constraints\Objects\Schema
     * @covers Fastwf\Constraint\Constraints\Required
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testValidateMaxErrors()
    {
        $subConstraint = new ArrayType();
        $constraint = new Schema([
            'properties' => [
                'name' => new StringType(),
                'age' => new IntegerType(),
                'wallets' => new Required(true, $subConstraint),
            ],
            'minProperties' => 3,
            'maxProperties' => 3,
        ]);

        $violation = $constraint->validate(
            Node::from(['value' => ['name' => 'foo', 'age' => 25, 'wallets' => [], 'other' => null]]),
            $this->context
        );

        $this->assertNotNull($violation);
        $this->assertEquals(0, count($violation->getChildren()));
        $this->assertEquals(1, count($violation->getViolations()));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     * @covers Fastwf\Constraint\Constraints\Objects\Schema
     * @covers Fastwf\Constraint\Api\ValidationContext
     */
    public function testValidateAdditionalProperties()
    {
        $constraint = new Schema([
            "additionalProperties" => new IntegerType(),
        ]);

        $this->assertNull($constraint->validate(
            Node::from(['value' => ['first' => 1, 'second' => 2, 'third' => 3]]),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Constraints\Objects\Schema
     * @covers Fastwf\Constraint\Constraints\Required
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testValidateAdditionalPropertiesError()
    {
        $constraint = new Schema([
            "additionalProperties" => new IntegerType(),
        ]);

        $violation = $constraint->validate(
            Node::from(['value' => ['first' => "1", 'second' => 2, 'third' => "3"]]),
            $this->context,
        );

        $this->assertNotNull($violation);
        $this->assertEquals(2, \count($violation->getChildren()));
    }

}
