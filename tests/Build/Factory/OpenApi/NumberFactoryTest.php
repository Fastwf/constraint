<?php

namespace Fastwf\Tests\Build\Factory\OpenApi;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Api\Validator;
use Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory;

class NumberFactoryTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\DoubleType
     * @covers Fastwf\Constraint\Constraints\Number\Minimum
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testNumberFactoryWithMinimumTrue()
    {
        $factory = new NumberFactory(null);

        $this->assertTrue(
            (new Validator($factory->create([
                'type' => 'number',
                'minimum' => 10,
            ])))->validate(15)
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\DoubleType
     * @covers Fastwf\Constraint\Constraints\Number\Minimum
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testNumberFactoryWithMinimumFalse()
    {
        $factory = new NumberFactory(null);

        $this->assertFalse(
            (new Validator($factory->create([
                'type' => 'number',
                'minimum' => 10,
            ])))->validate(5)
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\DoubleType
     * @covers Fastwf\Constraint\Constraints\Number\Maximum
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testNumberFactoryWithMaximumTrue()
    {
        $factory = new NumberFactory(null);

        $this->assertTrue(
            (new Validator($factory->create([
                'type' => 'number',
                'maximum' => 10,
            ])))->validate(5)
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\DoubleType
     * @covers Fastwf\Constraint\Constraints\Number\Maximum
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testNumberFactoryWithMaximumFalse()
    {
        $factory = new NumberFactory(null);

        $this->assertFalse(
            (new Validator($factory->create([
                'type' => 'number',
                'maximum' => 10,
            ])))->validate(15)
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\DoubleType
     * @covers Fastwf\Constraint\Constraints\Number\MultipleOf
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testNumberFactoryWithultipleOfmTrue()
    {
        $factory = new NumberFactory(null);

        $this->assertTrue(
            (new Validator($factory->create([
                'type' => 'number',
                'multipleOf' => 2,
            ])))->validate(10)
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\DoubleType
     * @covers Fastwf\Constraint\Constraints\Number\MultipleOf
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testNumberFactoryWithMultipleOfFalse()
    {
        $factory = new NumberFactory(null);

        $this->assertFalse(
            (new Validator($factory->create([
                'type' => 'number',
                'multipleOf' => 3,
            ])))->validate(10)
        );
    }

}
