<?php

namespace Fastwf\Constraint\Build\Loader;

/**
 * The provider definition that allows to load schema from various sources.
 */
interface ILoader
{

    /**
     * The default namespace.
     */
    public const DEFAULT = '';

    /**
     * Load the schema that correspond to the source.
     *
     * @param string $source the source name of the schema to load.
     * @param string|null $namespace the namespace of the schema (for default use null or ILoader::DEFAULT)
     * @return array|null the constraint schema to convert to constraint or null if not found.
     */
    public function load($source, $namespace = null);

}
