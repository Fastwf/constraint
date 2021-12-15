<?php

namespace Fastwf\Tests\Build\Environment;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Api\Validator;
use Fastwf\Constraint\Build\Loader\ILoader;
use Fastwf\Constraint\Build\Reader\PhpReader;
use Fastwf\Constraint\Build\Loader\ArrayLoader;
use Fastwf\Constraint\Exceptions\LoadException;
use Fastwf\Constraint\Build\Loader\FileSystemLoader;
use Fastwf\Constraint\Build\Factory\OpenApi\StringFactory;
use Fastwf\Constraint\Build\Environment\OpenApiEnvironment;

/**
 * Test OpenApiEnvironment and Environment classes
 */
class OpenApiEnvironmentTest extends TestCase
{

    private const SCHEMA_PATH = __DIR__ . '/../../../resources/schemas';

    /**
     * @covers Fastwf\Constraint\Build\Environment\Environment
     * @covers Fastwf\Constraint\Build\Environment\OpenApiEnvironment
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AllOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AnyOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\OneOfFactory
     */
    public function testSetGetLoader()
    {
        $expected = new ArrayLoader();

        $env = new OpenApiEnvironment(null);
        $env->setLoader($expected);

        $this->assertEquals($expected, $env->getLoader());
    }

    /**
     * @covers Fastwf\Constraint\Build\Environment\Environment
     * @covers Fastwf\Constraint\Build\Environment\OpenApiEnvironment
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AllOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AnyOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\OneOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     */
    public function testRegisterTypeFactoryAndGetDefault()
    {
        $env = OpenApiEnvironment::getDefault(new ArrayLoader());

        $this->assertTrue(
            $env->getTypeFactory('string') instanceof StringFactory,
        );
    }

    /**
     * @covers Fastwf\Constraint\Build\Environment\Environment
     * @covers Fastwf\Constraint\Build\Environment\OpenApiEnvironment
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AllOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AnyOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\OneOfFactory
     */
    public function testGetTypeFactoryError()
    {
        $this->expectException(LoadException::class);

        $env = new OpenApiEnvironment(new ArrayLoader());

        $env->getTypeFactory('unknown');
    }

    /**
     * @covers Fastwf\Constraint\Build\Environment\Environment
     * @covers Fastwf\Constraint\Build\Environment\OpenApiEnvironment
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AllOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AnyOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\OneOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\DoubleType
     */
    public function testLoadSchemaSimple()
    {
        $env = OpenApiEnvironment::getDefault(new ArrayLoader());

        $constraint = null;
        $env->loadSchema(['type' => 'number'], $constraint);

        $this->assertNotNull($constraint);
    }

    /**
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ViolationIterator 
     * @covers Fastwf\Constraint\Build\Environment\Environment
     * @covers Fastwf\Constraint\Build\Environment\OpenApiEnvironment
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AllOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AnyOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\OneOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\DoubleType
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testLoadSchemaAny()
    {
        $env = OpenApiEnvironment::getDefault(new ArrayLoader());

        $constraint = null;
        $env->loadSchema([], $constraint);

        $this->assertNotNull($constraint);

        $validator = new Validator($constraint);
        $this->assertTrue($validator->validate(10));
        $this->assertTrue($validator->validate('string'));
        $this->assertTrue($validator->validate(true));
        $this->assertFalse($validator->validate(null));
    }

    /**
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ViolationIterator 
     * @covers Fastwf\Constraint\Build\Environment\Environment
     * @covers Fastwf\Constraint\Build\Environment\OpenApiEnvironment
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AllOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AnyOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\OneOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     * @covers Fastwf\Constraint\Constraints\Logic\Not
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\DoubleType
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testSetLogicalConstraint()
    {
        $env = OpenApiEnvironment::getDefault(new ArrayLoader());

        $constraint = null;
        $env->loadSchema(['not' => ['type' => 'number']], $constraint);

        $this->assertNotNull($constraint);

        $validator = new Validator($constraint);
        $this->assertTrue($validator->validate([]));
        $this->assertTrue($validator->validate('string'));
        $this->assertTrue($validator->validate(true));
        $this->assertFalse($validator->validate(10));
    }

    /**
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ViolationIterator 
     * @covers Fastwf\Constraint\Build\Environment\ConstraintPool
     * @covers Fastwf\Constraint\Build\Environment\Environment
     * @covers Fastwf\Constraint\Build\Environment\OpenApiEnvironment
     * @covers Fastwf\Constraint\Build\Loader\FileSystemLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\ArrayFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AllOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AnyOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\OneOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\IntegerFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     * @covers Fastwf\Constraint\Build\Reader\PhpReader
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\DoubleType
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Constraints\Arrays\Count
     * @covers Fastwf\Constraint\Constraints\Arrays\Items
     * @covers Fastwf\Constraint\Constraints\Arrays\MinItems
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testLoadBasic()
    {
        $env = OpenApiEnvironment::getDefault(new FileSystemLoader(
            [
                ILoader::DEFAULT => [self::SCHEMA_PATH],
            ],
            ['php' => new PhpReader()],
        ));

        $constraint = null;
        $env->load('basic.php', $constraint);

        $validator = new Validator($constraint);
        $this->assertTrue($validator->validate([1, 2, 3]));
        $this->assertFalse($validator->validate([3.14, 2.7]));
    }

    /**
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ViolationIterator 
     * @covers Fastwf\Constraint\Build\Environment\ConstraintPool
     * @covers Fastwf\Constraint\Build\Environment\Environment
     * @covers Fastwf\Constraint\Build\Environment\OpenApiEnvironment
     * @covers Fastwf\Constraint\Build\Loader\FileSystemLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\ArrayFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AllOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AnyOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\OneOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\ObjectFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     * @covers Fastwf\Constraint\Build\Reader\PhpReader
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Constraints\Required
     * @covers Fastwf\Constraint\Constraints\Arrays\Count
     * @covers Fastwf\Constraint\Constraints\Arrays\Items
     * @covers Fastwf\Constraint\Constraints\Arrays\MinItems
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ObjectType
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\Objects\Schema
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testLoadWithCircularRef()
    {
        $env = OpenApiEnvironment::getDefault(new FileSystemLoader(
            [
                ILoader::DEFAULT => [self::SCHEMA_PATH],
            ],
            ['php' => new PhpReader()],
        ));

        $constraint = null;
        $env->load('node.php', $constraint);

        $validator = new Validator($constraint);
        $this->assertTrue($validator->validate([
            'parent' => null,
            'foo' => [
                'parent' => [
                    'parent' => null,
                    'foo' => [
                        'value' => '$ref1'
                    ],
                ],
                'value' => 'bar',
            ]
        ]));
    }

    /**
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ViolationIterator 
     * @covers Fastwf\Constraint\Build\Environment\ConstraintPool
     * @covers Fastwf\Constraint\Build\Environment\Environment
     * @covers Fastwf\Constraint\Build\Environment\OpenApiEnvironment
     * @covers Fastwf\Constraint\Build\Loader\FileSystemLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\ArrayFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AllOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AnyOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\LAFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\OneOfFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\ObjectFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\StringFactory
     * @covers Fastwf\Constraint\Build\Reader\PhpReader
     * @covers Fastwf\Constraint\Constraints\Nullable
     * @covers Fastwf\Constraint\Constraints\Required
     * @covers Fastwf\Constraint\Constraints\Arrays\Count
     * @covers Fastwf\Constraint\Constraints\Arrays\Items
     * @covers Fastwf\Constraint\Constraints\Arrays\MinItems
     * @covers Fastwf\Constraint\Constraints\Logic\AllOf
     * @covers Fastwf\Constraint\Constraints\String\Blank
     * @covers Fastwf\Constraint\Constraints\String\DateFormat
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\NotBlank
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\ObjectType
     * @covers Fastwf\Constraint\Constraints\Type\StringType
     * @covers Fastwf\Constraint\Constraints\Chain
     * @covers Fastwf\Constraint\Constraints\Objects\Schema
     * @covers Fastwf\Constraint\Constraints\Type\ArrayType
     * @covers Fastwf\Constraint\Data\ArrayNode
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testLoadComplexNoCircular()
    {
        $env = OpenApiEnvironment::getDefault(new FileSystemLoader(
            [
                ILoader::DEFAULT => [self::SCHEMA_PATH],
            ],
            ['php' => new PhpReader()],
        ));

        $constraint = null;
        $env->load('model.php', $constraint);

        $validator = new Validator($constraint);
        $this->assertTrue($validator->validate([
            'start' => [
                'name' => 'foo',
                'date' => '2021-12-01',
            ],
            'end' => [
                'date' => '2021-12-31',
            ],
        ]));
    }

}
