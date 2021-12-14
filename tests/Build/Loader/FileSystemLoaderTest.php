<?php

namespace Fastwf\Tests\Build\Loader;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Build\Loader\ILoader;
use Fastwf\Constraint\Build\Reader\PhpReader;
use Fastwf\Constraint\Build\Reader\JsonReader;
use Fastwf\Constraint\Exceptions\LoadException;
use Fastwf\Constraint\Build\Loader\FileSystemLoader;

class FileSystemLoaderTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Build\Loader\FileSystemLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     */
    public function testLoadNothing()
    {
        $loader = new FileSystemLoader([], []);

        $this->assertNull($loader->load('test'));
    }

    /**
     * @covers Fastwf\Constraint\Build\Loader\FileSystemLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Reader\PhpReader
     */
    public function testAddPath()
    {
        $loader = new FileSystemLoader([], ['php' => new PhpReader()]);
        $loader->addPath(__DIR__ . '/../../../resources');

        $this->assertNotNull($loader->load('schema.php'));
    }

    /**
     * @covers Fastwf\Constraint\Build\Loader\FileSystemLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Reader\JsonReader
     */
    public function testAddRemoveReaderThrowsLoadException()
    {
        $this->expectException(LoadException::class);

        $loader = new FileSystemLoader([], []);
        $loader->addPath(__DIR__ . '/../../../resources');

        $loader->setReader('json', new JsonReader());
        $this->assertNotNull($loader->load('schema.json'));

        $loader->removeReader('json');
        $loader->load('schema.json');
    }

    /**
     * @covers Fastwf\Constraint\Build\Loader\FileSystemLoader
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Reader\PhpReader
     */
    public function testPrependPath()
    {
        $loader = new FileSystemLoader(
            [ILoader::DEFAULT => [__DIR__ . '/../../../resources']],
            ['php' => new PhpReader()]
        );
        $loader->prependPath(__DIR__ . '/../../../resources/primary');

        $this->assertEquals('primary', $loader->load('schema.php')['name']);
    }

}
