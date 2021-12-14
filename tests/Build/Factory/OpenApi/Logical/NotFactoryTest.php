<?php

namespace Fastwf\Tests\Build\Factory\OpenApi\Logical;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Constraints\Logic\Not;
use Fastwf\Constraint\Build\Loader\ArrayLoader;
use Fastwf\Tests\Build\Environment\TestingEnvironment;
use Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory;

/**
 * Test NotFactory and LogicalFactory
 */
class NotFactoryTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory
     */
    public function testMatchTrue()
    {
        $factory = new NotFactory(null);

        $this->assertTrue($factory->match(['not' => null]));
    }

    /**
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory
     */
    public function testMatchFalse()
    {
        $factory = new NotFactory(null);

        $this->assertFalse($factory->match(['allOf' => null]));
    }

    /**
     * @covers Fastwf\Constraint\Build\Environment\Environment
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Constraints\Logic\Not
     */
    public function testCreate()
    {
        $factory = new NotFactory(new TestingEnvironment(new ArrayLoader()));

        $this->assertTrue($factory->create(['not' => []]) instanceof Not);
    }

}
