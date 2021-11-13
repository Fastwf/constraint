<?php

namespace Fastwf\Tests\Utils;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Utils\Range;

class RangeTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Utils\Range
     */
    public function testInRange()
    {
        $this->assertTrue(Range::inRange(0, 0, 10));
    }

    /**
     * @covers Fastwf\Constraint\Utils\Range
     */
    public function testNotInRange()
    {
        $this->assertFalse(Range::inRange(10, 0, 10));
    }

}
