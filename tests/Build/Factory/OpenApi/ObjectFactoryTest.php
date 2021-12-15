<?php

namespace Fastwf\Tests\Build\Factory\OpenApi;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Api\Validator;
use Fastwf\Constraint\Build\Factory\OpenApi\ObjectFactory;

class ObjectFactoryTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\ObjectFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ObjectType
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testBasicSchema()
    {
        $factory = new ObjectFactory(null);

        $this->assertTrue(
            (new Validator($factory->create([
                'type' => 'object',
            ])))->validate(['foo' => 'bar'])
        );
        $this->assertFalse(
            (new Validator($factory->create([
                'type' => 'array',
            ])))->validate([1, 2, 3])
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\ObjectFactory
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ObjectType
     * @covers Fastwf\Constraint\Constraints\Objects\Schema
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testMinProperties()
    {
        $factory = new ObjectFactory(null);

        $constraint = $factory->create([
            'type' => 'object',
            'minProperties' => 2,
        ]);

        $this->assertTrue(
            (new Validator($constraint))->validate(['name' => 'foo', 'age' => 25])
        );
        $this->assertFalse(
            (new Validator($constraint))->validate(['name' => 'foo'])
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\ObjectFactory
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ObjectType
     * @covers Fastwf\Constraint\Constraints\Objects\Schema
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testMaxProperties()
    {
        $factory = new ObjectFactory(null);

        $constraint = $factory->create([
            'type' => 'object',
            'maxProperties' => 1,
        ]);

        $this->assertTrue(
            (new Validator($constraint))->validate(['name' => 'foo'])
        );
        $this->assertFalse(
            (new Validator($constraint))->validate(['name' => 'foo', 'age' => 25])
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\ObjectFactory
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\Required
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ObjectType
     * @covers Fastwf\Constraint\Constraints\Objects\Schema
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testRequiredProperties()
    {
        $factory = new ObjectFactory(null);

        $constraint = $factory->create([
            'type' => 'object',
            'required' => ['age'],
        ]);

        $this->assertTrue(
            (new Validator($constraint))->validate(['name' => 'foo', 'age' => 25])
        );
        $this->assertFalse(
            (new Validator($constraint))->validate(['name' => 'foo'])
        );
    }

}
