<?php

namespace Fastwf\Constraint\Build\Loader;

use Fastwf\Constraint\Build\Loader\ILoader;

/**
 * Base loader class that allows to use namespace system.
 */
abstract class NameSpaceLoader implements ILoader
{

    protected $namespace;

    public function __construct()
    {
        $this->namespace = [];
    }

    /**
     * Get the namespace as string (null is transformed in ILoader::DEFAULT).
     *
     * @param string|null $namespace the original namespace
     * @return string the safe namespace
     */
    private static function safeNameSpace($namespace)
    {
        return $namespace === null ? ILoader::DEFAULT : $namespace; 
    }

    /**
     * Get the array associated to the namespace.
     *
     * @param string|null $namespace the original namespace
     * @return array the array reference associated to the namespace.
     */
    protected function &getNameSpace($namespace)
    {
        $safe = self::safeNameSpace($namespace);

        if (!\array_key_exists($safe, $this->namespace))
        {
            $this->namespace[$safe] = [];
        }

        return $this->namespace[$safe];
    }

}
