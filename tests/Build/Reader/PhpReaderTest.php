<?php

namespace Fastwf\Tests\Build\Reader;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Build\Reader\PhpReader;

class PhpReaderTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Build\Reader\PhpReader
     */
    public function testRead()
    {
        $reader = new PhpReader();

        $path = __DIR__ . '/../../../resources/schema.php';

        $this->assertEquals(require($path), $reader->read($path));
    }

}
