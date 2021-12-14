<?php

namespace Fastwf\Tests\Build\Factory\OpenApi\Logical;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Constraints\Logic\OneOf;
use Fastwf\Constraint\Build\Loader\ArrayLoader;
use Fastwf\Tests\Build\Environment\TestingEnvironment;
use Fastwf\Constraint\Build\Factory\OpenApi\Logical\OneOfFactory;

class OneOfFactoryTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\LAFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\OneOfFactory
     */
    public function testMatch()
    {
        $factory = new OneOfFactory(null);

        $this->assertTrue($factory->match(['oneOf' => []]));
        $this->assertFalse($factory->match(['$ref' => 'Model']));
    }

    /**
     * @covers Fastwf\Constraint\Build\Environment\Environment
     * @covers Fastwf\Constraint\Build\Factory\LogicalFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\LAFactory
     * @covers Fastwf\Constraint\Build\Factory\OpenApi\Logical\OneOfFactory
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Constraints\Logic\OneOf
     */
    public function test()
    {
        $factory = new OneOfFactory(new TestingEnvironment(new ArrayLoader()));

        $this->assertTrue($factory->create(['oneOf' => []]) instanceof OneOf);
    }

}
