<?php

namespace Fastwf\Constraint\Build\Loader;

use Fastwf\Constraint\Build\Loader\ILoader;

/**
 * The chain loader allows to use mutiple loader instance to load a schema using source.
 * 
 * This loader try all loaders registered to find a schema that match the source name.
 * 
 * The resolution order depend on the ILoader position.  
 * The loader have the priority on the next item of the collection, but not on the previous.
 */
class ChainLoader implements ILoader
{

    /**
     * The array of ILoader
     *
     * @var array
     */
    private $loaders;

    public function __construct($loaders = [])
    {
        $this->loaders = $loaders;
    }

    /**
     * Add the loader at the end of the loader collection.
     *
     * @param ILoader $loader the loader to insert.
     * @return void
     */
    public function addLoader($loader)
    {
        \array_push($this->loaders, $loader);
    }

    /**
     * Add the loader at the beggining of the loader collection.
     *
     * @param ILoader $loader the loader to insert.
     * @return void
     */
    public function prependLoader($loader)
    {
        \array_unshift($this->loaders, $loader);
    }

    public function load($source, $namespace = null)
    {
        foreach ($this->loaders as $loader) {
            $schema = $loader->load($source, $namespace);

            if ($schema !== null)
            {
                return $schema;
            }
        }

        return null;
    }

}
