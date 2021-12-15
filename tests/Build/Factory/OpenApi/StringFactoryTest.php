<?php

namespace Fastwf\Tests\Build\Factory\OpenApi;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Api\Validator;
use Fastwf\Constraint\Exceptions\LoadException;
use Fastwf\Constraint\Constraints\String\NotBlank;
use Fastwf\Constraint\Build\Factory\OpenApi\StringFactory;

class StringFactoryTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testBasicSchema()
    {
        $factory = new StringFactory(null);

        $this->assertTrue(
            (new Validator($factory->create([
                'type' => 'string',
            ])))->validate('hello world')
        );
        $this->assertFalse(
            (new Validator($factory->create([
                'type' => 'string',
            ])))->validate(10)
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\String\Blank
     * @covers Fastwf\Constraint\Constraints\String\NotBlank
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testGetDefaultAndSetFormat()
    {
        $factory = StringFactory::getDefault(null);

        $this->assertTrue(
            (new Validator($factory->create([
                'type' => 'string',
                'format' => 'not-blank'
            ])))->validate('test')
        );
        $this->assertFalse(
            (new Validator($factory->create([
                'type' => 'string',
                'format' => 'not-blank'
            ])))->validate(" \t  ")
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\String\NotBlank
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testRemoveFormat()
    {
        $this->expectException(LoadException::class);

        $factory = new StringFactory(null);
        $factory->setFormat('not-blank', NotBlank::class);
        $factory->removeFormat('not-blank');

        $factory->create([
            'type' => 'string',
            'format' => 'not-blank'
        ]);
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\String\Enum
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testEnum()
    {
        $factory = new StringFactory(null);

        $constraint = $factory->create([
            'type' => 'string',
            'enum' => ['one', 'two', 'three'],
        ]);

        $this->assertTrue(
            (new Validator($constraint))->validate('one')
        );
        $this->assertFalse(
            (new Validator($constraint))->validate('zero')
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\String\Pattern
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testPattern()
    {
        $factory = new StringFactory(null);

        $constraint = $factory->create([
            'type' => 'string',
            'pattern' => "\\d+,\\d+",
        ]);

        $this->assertTrue(
            (new Validator($constraint))->validate('3,14')
        );
        $this->assertFalse(
            (new Validator($constraint))->validate('3.14')
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\String\Length
     * @covers Fastwf\Constraint\Constraints\String\MinLength
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testMinLength()
    {
        $factory = new StringFactory(null);

        $constraint = $factory->create([
            'type' => 'string',
            'minLength' => 3,
        ]);

        $this->assertTrue(
            (new Validator($constraint))->validate('she')
        );
        $this->assertFalse(
            (new Validator($constraint))->validate('he')
        );
    }

    /**
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\String\Length
     * @covers Fastwf\Constraint\Constraints\String\MaxLength
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testMaxLength()
    {
        $factory = new StringFactory(null);

        $constraint = $factory->create([
            'type' => 'string',
            'maxLength' => 2,
        ]);

        $this->assertTrue(
            (new Validator($constraint))->validate('he')
        );
        $this->assertFalse(
            (new Validator($constraint))->validate('she')
        );
    }

}
