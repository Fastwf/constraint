<?php

namespace Fastwf\Tests\Build\Factory\OpenApi;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Api\Validator;
use Fastwf\Constraint\Build\Factory\OpenApi\ArrayFactory;

class ArrayFactoryTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\ArrayFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testBasicSchema()
    {
        $factory = new ArrayFactory(null);

        $this->assertTrue(
            (new Validator($factory->create([
                'type' => 'array',
            ])))->validate([1, 2, 3])
        );
        $this->assertFalse(
            (new Validator($factory->create([
                'type' => 'array',
            ])))->validate('string')
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\ArrayFactory
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Constraints\Arrays\Count
     * @covers Fastwf\Constraint\Constraints\Arrays\MinItems
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testMinItems()
    {
        $factory = new ArrayFactory(null);

        $constraint = $factory->create([
            'type' => 'array',
            'minItems' => 3,
        ]);

        $this->assertTrue(
            (new Validator($constraint))->validate([1, 2, 3])
        );
        $this->assertFalse(
            (new Validator($constraint))->validate([1, 2])
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\ArrayFactory
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Constraints\Arrays\Count
     * @covers Fastwf\Constraint\Constraints\Arrays\MaxItems
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testMaxItems()
    {
        $factory = new ArrayFactory(null);

        $constraint = $factory->create([
            'type' => 'array',
            'maxItems' => 2,
        ]);

        $this->assertTrue(
            (new Validator($constraint))->validate([1, 2])
        );
        $this->assertFalse(
            (new Validator($constraint))->validate([1, 2, 3])
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\ArrayFactory
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Constraints\Arrays\UniqueItems
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testUniqueItems()
    {
        $factory = new ArrayFactory(null);

        $constraint = $factory->create([
            'type' => 'array',
            'uniqueItems' => true,
        ]);

        $this->assertTrue(
            (new Validator($constraint))->validate([1, 2])
        );
        $this->assertFalse(
            (new Validator($constraint))->validate([1, 2, 2])
        );
    }

}
