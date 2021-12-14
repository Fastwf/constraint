<?php

namespace Fastwf\Tests\Build\Environment;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Constraints\Required;
use Fastwf\Constraint\Build\Environment\ConstraintPool;

class ConstraintPoolTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Build\Environment\ConstraintPool
     */
    public function testHasFalse()
    {
        $pool = new ConstraintPool();

        $this->assertFalse($pool->has('Model'));
    }

    /**
     * @covers Fastwf\Constraint\Build\Environment\ConstraintPool
     */
    public function testHasTrue()
    {
        $pool = new ConstraintPool();
        $pool->startLoading('Model');

        $this->assertTrue($pool->has('Model'));
    }

    /**
     * @covers Fastwf\Constraint\Build\Environment\ConstraintPool
     */
    public function testIsLoadedFalse()
    {
        $pool = new ConstraintPool();
        $pool->startLoading('Model');

        $this->assertFalse($pool->isLoaded('Model'));
    }

    /**
     * @covers Fastwf\Constraint\Build\Environment\ConstraintPool
     * @covers Fastwf\Constraint\Constraints\Required
     */
    public function testIsLoadedTrue()
    {
        $pool = new ConstraintPool();
        $pool->setLoaded('Model', new Required(false));

        $this->assertTrue($pool->isLoaded('Model'));
    }

    /**
     * @covers Fastwf\Constraint\Build\Environment\ConstraintPool
     * @covers Fastwf\Constraint\Constraints\Required
     */
    public function testAddLoadCallback()
    {
        $pool = new ConstraintPool();

        $first = 0;
        $second = 0;
        $out = null;

        $pool->addLoadCallback('Model', function ($constraint) use (&$first) {
            $first++;
        });
        $pool->addLoadCallback('Model', function ($constraint) use (&$second, &$out) {
            $second++;
            $out = $constraint;
        });

        $constraint = new Required(false);
        $pool->setLoaded('Model', $constraint);

        $this->assertEquals(2, $first + $second);
        $this->assertEquals($constraint, $out);
    }

}
