<?php

namespace Fastwf\Tests\Utils\Iterators;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator;

class ArrayNodeIteratorTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator
     */
    public function testIterator()
    {
        $it = new ArrayNodeIterator([1, 2, 3]);
        $it->rewind();

        $count = 0;
        while ($it->valid())
        {
            // Check key and value class
            $this->assertEquals($count, $it->key());
            $this->assertTrue($it->current() instanceof Node);

            $it->next();
            $count++;
        }

        // Check the number of items
        $this->assertEquals(3, $count);
    }

}
