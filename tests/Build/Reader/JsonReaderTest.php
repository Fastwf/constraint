<?php

namespace Fastwf\Tests\Build\Reader;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Build\Reader\JsonReader;

class JsonReaderTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Build\Reader\JsonReader
     */
    public function testRead()
    {
        $reader = new JsonReader();

        $path = __DIR__ . '/../../../resources/schema.json';

        $this->assertEquals(\json_decode(\file_get_contents($path)), $reader->read($path));
    }

}
