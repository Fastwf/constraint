<?php

namespace Fastwf\Tests\Build\Loader;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Build\Loader\ArrayLoader;

/**
 * Test the ArrayLoader methods and the NameSpaceLoader abstract class.
 */
class ArrayLoaderTest extends TestCase
{
    
    /**
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     */
    public function testLoadWithNameSpace()
    {
        $loader = new ArrayLoader(['test' => ['testSchema' => ['nullable' => true]]]);

        $this->assertNotNull($loader->load('testSchema', 'test'));
    }
    
    /**
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     */
    public function testSetSchema()
    {
        $loader = new ArrayLoader();
        $loader->setSchema('testSchema', ['nullable' => true]);

        // Test the schema is correctly loaded and the namespace safely accessed
        $this->assertNotNull($loader->load('testSchema'));
    }
    
    /**
     * @covers Fastwf\Constraint\Build\Loader\NameSpaceLoader
     * @covers Fastwf\Constraint\Build\Loader\ArrayLoader
     */
    public function testRemoveSchemaAndLoadNotExists()
    {
        $loader = new ArrayLoader(['test' => ['testSchema' => ['nullable' => true]]]);
        $loader->removeSchema('testSchema', 'test');

        $this->assertNull($loader->load('testSchema', 'test'));
    }

}
