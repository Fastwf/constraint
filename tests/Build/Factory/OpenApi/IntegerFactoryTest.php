<?php

namespace Fastwf\Tests\Build\Factory\OpenApi;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Api\Validator;
use Fastwf\Constraint\Build\Factory\OpenApi\IntegerFactory;

class IntegerFactoryTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\IntegerFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\DoubleType
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     * @covers Fastwf\Constraint\Constraints\Number\Minimum
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testIntegerFactoryTrue()
    {
        $factory = new IntegerFactory(null);

        $this->assertTrue(
            (new Validator($factory->create([
                'type' => 'integer',
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
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\IntegerFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\DoubleType
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     * @covers Fastwf\Constraint\Constraints\Number\Minimum
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testIntegerFactoryFalse()
    {
        $factory = new IntegerFactory(null);

        $this->assertFalse(
            (new Validator($factory->create([
                'type' => 'integer',
            ])))->validate(3.14)
        );
    }

}
