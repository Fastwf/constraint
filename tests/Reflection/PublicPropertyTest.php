<?php

namespace Fastwf\Tests\Reflection;

use Fastwf\Tests\Model\Data;
use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Reflection\PublicProperty;

class PublicPropertyTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\PublicProperty
     */
    public function testGet()
    {
        $data = new Data();
        $data->name = 'root';

        $reflection = new \ReflectionClass($data);
        $this->assertEquals('root', (new PublicProperty($reflection->getProperty('name')))->get($data)->get());
    }

    /**
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\PublicProperty
     */
    public function testSet()
    {
        $data = new Data();
        $data->name = 'root';

        $reflection = new \ReflectionClass($data);

        (new PublicProperty($reflection->getProperty('name')))->set($data, 'child');

        $this->assertEquals('child', $data->name);
    }

}
