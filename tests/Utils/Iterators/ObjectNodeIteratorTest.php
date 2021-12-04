<?php

namespace Fastwf\Tests\Utils\Iterators;

use Fastwf\Tests\Model\Data;
use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Utils\Iterators\ObjectNodeIterator;

class ObjectNodeIteratorTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Utils\Iterators\ObjectNodeIterator
     * @covers Fastwf\Constraint\Reflection\Method
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\PublicProperty
     * @covers Fastwf\Constraint\Reflection\StdProperty
     */
    public function testIteration()
    {
        $data = new Data();
        $cache = [];

        $it = new ObjectNodeIterator($data, new \ReflectionClass($data), $cache);

        $collector = ['name', 'parent', 'root', 'isAlive', 'children', 'super', 'superParent'];

        $it->rewind();
        while ($it->valid())
        {
            $index = \array_search($it->key(), $collector, true);

            // internal must not be provided, so index !== false
            $this->assertTrue($index !== false);
            // remove the value property name from the array to verify that all readable properties are iterated
            unset($collector[$index]);

            $this->assertTrue($it->current() instanceof Node);

            $it->next();
        }

        $this->assertTrue(empty($collector));
        $this->assertFalse(empty($cache));
    }

}
