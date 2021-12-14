<?php

namespace Fastwf\Tests\Build\Loader;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Build\Loader\ILoader;
use Fastwf\Constraint\Build\Loader\ArrayLoader;
use Fastwf\Constraint\Build\Loader\ChainLoader;

class ChainLoaderTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Build\Loader\ChainLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     */
    public function testLoadNull()
    {
        $loader = new ChainLoader();

        $this->assertNull($loader->load('test'));
    }

    /**
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     * @covers Fastwf\Constraint\Build\Loader\ChainLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     */
    public function testAddLoader()
    {
        $loader = new ChainLoader([
            new ArrayLoader([ILoader::DEFAULT => ['primary' => ['order' => 1]]]),
        ]);
        $loader->addLoader(
            new ArrayLoader([ILoader::DEFAULT => ['secondary' => ['order' => 2]]]),
        );

        $this->assertEquals(2, $loader->load('secondary')['order']);
    }

    /**
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     * @covers Fastwf\Constraint\Build\Loader\ChainLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     */
    public function testPrependLoader()
    {
        $loader = new ChainLoader([
            new ArrayLoader([ILoader::DEFAULT => ['primary' => ['order' => 1]]]),
        ]);
        $loader->prependLoader(
            new ArrayLoader([ILoader::DEFAULT => ['primary' => ['order' => 2]]]),
        );

        $this->assertEquals(2, $loader->load('primary')['order']);
    }

}
