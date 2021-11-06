<?php

namespace Fastwf\Tests\Reflection;

use Fastwf\Tests\Model\Data;
use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Reflection\Method;

class MethodTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Reflection\Method
     */
    public function testInvoke()
    {
        $data = new Data();
        $data->setRoot(true);

        $reflection = new \ReflectionClass($data);
        $method = new Method($reflection->getMethod('isRoot'));

        $this->assertTrue($method->invoke($data)->get());
    }

}
