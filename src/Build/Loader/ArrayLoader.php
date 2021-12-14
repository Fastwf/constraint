<?php

namespace Fastwf\Constraint\Build\Loader;

use Fastwf\Constraint\Build\Loader\NameSpaceLoader;

/**
 * Array schema loader.
 * 
 * Load a schema using in memory internal associative array.
 */
class ArrayLoader extends NameSpaceLoader
{

    /**
     * Constructor.
     *
     * @param array $namespace the base namespace schema array (default namespace is ILoader::DEFAULT)
     */
    public function __construct($namespace = [])
    {
        parent::__construct();

        $this->namespace = $namespace;
    }

    /**
     * Set or override the schema for the $source key.
     *
     * @param string $source the source name of the schema to load.
     * @param array $schema the constraint schema to convert to constraint.
     * @param string|null $namespace the namespace of the schema (for default use null or ILoader::DEFAULT)
     * @return void
     */
    public function setSchema($source, $schema, $namespace = null)
    {
        $this->getNameSpace($namespace)[$source] = $schema;
    }

    /**
     * Remove the schema associated to the source if is set (nothing appens if not set).
     *
     * @param string $source the source name of the schema to load.
     * @param string|null $namespace the namespace of the schema (for default use null or ILoader::DEFAULT)
     * @return void
     */
    public function removeSchema($source, $namespace = null)
    {
        $schema = &$this->getNameSpace($namespace);
        if (\array_key_exists($source, $schema))
        {
            unset($schema[$source]);
        }
    }

    public function load($source, $namespace = null)
    {
        $schema = $this->getNameSpace($namespace);
        if (\array_key_exists($source, $schema))
        {
            return $schema[$source];
        }

        return null;
    }

}
