<?php

namespace Fastwf\Tests\Build\Factory\OpenApi\Logical;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Constraints\Logic\AnyOf;
use Fastwf\Constraint\Build\Loader\ArrayLoader;
use Fastwf\Tests\Build\Environment\TestingEnvironment;
use Fastwf\Constraint\Build\Factory\OpenApi\Logical\AnyOfFactory;

class AnyOfFactoryTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\LAFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AnyOfFactory
     */
    public function testMatch()
    {
        $factory = new AnyOfFactory(null);

        $this->assertTrue($factory->match(['anyOf' => []]));
        $this->assertFalse($factory->match(['$ref' => 'Model']));
    }

    /**
     * @covers Fastwf\Constraint\Build\Environment\Environment
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\LAFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AnyOfFactory
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Constraints\Logic\AnyOf
     */
    public function test()
    {
        $factory = new AnyOfFactory(new TestingEnvironment(new ArrayLoader()));

        $this->assertTrue($factory->create(['anyOf' => []]) instanceof AnyOf);
    }

}
