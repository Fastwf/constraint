<?php

namespace Fastwf\Tests\Build\Factory\OpenApi\Logical;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Constraints\Logic\AllOf;
use Fastwf\Constraint\Build\Loader\ArrayLoader;
use Fastwf\Tests\Build\Environment\TestingEnvironment;
use Fastwf\Constraint\Build\Factory\OpenApi\Logical\AllOfFactory;

/**
 * Test AllOfFactoryTest and LAFactory
 */
class AllOfFactoryTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\LAFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AllOfFactory
     */
    public function testMatch()
    {
        $factory = new AllOfFactory(null);

        $this->assertTrue($factory->match(['allOf' => []]));
        $this->assertFalse($factory->match(['$ref' => 'Model']));
    }

    /**
     * @covers Fastwf\Constraint\Build\Environment\Environment
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\LAFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\AllOfFactory
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Constraints\Logic\AllOf
     */
    public function test()
    {
        $factory = new AllOfFactory(new TestingEnvironment(new ArrayLoader()));

        $this->assertTrue($factory->create(['allOf' => []]) instanceof AllOf);
    }

}
