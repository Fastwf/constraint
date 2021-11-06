<?php

namespace Fastwf\Tests\Reflection;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Reflection\UndefinedGetterMethod;

class UndefinedGetterMethodTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Reflection\UndefinedGetterMethod
     */
    public function testInvoke()
    {
        $method = new UndefinedGetterMethod();

        $this->assertFalse($method->invoke(null)->isDefined());
    }

}
