<?php

namespace Fastwf\Tests\Build\Factory\OpenApi;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Api\Validator;
use Fastwf\Constraint\Constraints\Nullable;
use Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory;

class AnyFactoryTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\BooleanType
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testCreateNullableFalse()
    {
        $factory = new AnyFactory(null);

        $constraint = $factory->create([]);
        $this->assertTrue($constraint instanceof Nullable);

        $this->assertFalse((new Validator($constraint))->validate(null));
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\BooleanType
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testCreateNullableTrue()
    {
        $factory = new AnyFactory(null);
        $constraint = $factory->create(['nullable' => true]);

        $this->assertTrue((new Validator($constraint))->validate(null));
    }

}
