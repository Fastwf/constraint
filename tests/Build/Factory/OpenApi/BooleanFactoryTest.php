<?php

namespace Fastwf\Tests\Build\Factory\OpenApi;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Api\Validator;
use Fastwf\Constraint\Constraints\Nullable;
use Fastwf\Constraint\Build\Factory\OpenApi\BooleanFactory;

class BooleanFactoryTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\BooleanFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\BooleanType
     * @covers Fastwf\Constraint\Data\Node
     */
    public function testCreateValid()
    {
        $factory = new BooleanFactory(null);

        $constraint = $factory->create(['type' => 'boolean']);

        $this->assertTrue((new Validator($constraint))->validate(true));
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\BooleanFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\BooleanType
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testCreateInvalid()
    {
        $factory = new BooleanFactory(null);

        $constraint = $factory->create(['type' => 'boolean']);
        $this->assertFalse((new Validator($constraint))->validate('test'));
    }

}
