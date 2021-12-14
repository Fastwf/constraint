<?php

namespace Fastwf\Constraint\Build\Loader;

use Fastwf\Constraint\Build\Reader\IReader;
use Fastwf\Constraint\Exceptions\LoadException;
use Fastwf\Constraint\Build\Loader\NameSpaceLoader;

/**
 * File system loader implementation.
 * 
 * This loader allows to find a constraint model definition using file schema loading system.
 * 
 * For each namespace, a direcotry list is used to try to find the file containing the schema.
 * The directory priority is based on the order of namespace directory collection.
 */
class FileSystemLoader extends NameSpaceLoader
{

    /**
     * The associative string key / IReader implementation array.
     *
     * @var array
     */
    private $readers;

    /**
     * Constructor.
     *
     * @param array $namespaceDirectories the array containing namespace as key and the array of directories as values.
     * @param array $readers the associative string key / IReader implementation array.
     */
    public function __construct($namespaceDirectories, $readers)
    {
        parent::__construct();

        $this->namespace = $namespaceDirectories;
        $this->readers = $readers;
    }

    /**
     * Add the path at the end of the directory list associated to the given namespace.
     *
     * @param string $directory the path to the directory to add.
     * @param string|null $namespace the namespace of the schema directory (for default use null or ILoader::DEFAULT)
     * @return void
     */
    public function addPath($directory, $namespace = null)
    {
        \array_push($this->getNameSpace($namespace), $directory);
    }

    /**
     * Add the path at the beggining of the directory list associated to the given namespace.
     *
     * @param string $directory the path to the directory to add.
     * @param string|null $namespace the namespace of the schema directory (for default use null or ILoader::DEFAULT)
     * @return void
     */
    public function prependPath($directory, $namespace = null)
    {
        \array_unshift($this->getNameSpace($namespace), $directory);
    }

    /**
     * Set or override the IReader associated to the file extension.
     *
     * @param string $name the file extension (must be in lowercase).
     * @param IReader $reader the reader implementation.
     * @return void
     */
    public function setReader($name, $reader)
    {
        $this->readers[$name] = $reader;
    }

    /**
     * Remove the IReader associated to the file extension (nothing appens when the file extension is not set).
     *
     * @param string $name the file extension (must be in lowercase).
     * @return void
     */
    public function removeReader($name)
    {
        unset($this->readers[$name]);
    }

    public function load($source, $namespace = null)
    {
        // Iterate over each registered directories to find the source file.
        foreach ($this->getNameSpace($namespace) as $directory)
        {
            $path = join(DIRECTORY_SEPARATOR, [$directory, $source]);

            if (\file_exists($path))
            {
                // When the file exists, analyse the extension to use the right IReader
                $info = pathinfo($path);

                $extension = \array_key_exists('extension', $info) ? \strtolower($info['extension']) : null;

                // Read the file content using the IReader or throw an error because of missing reader
                if ($extension !== null && \array_key_exists($extension, $this->readers))
                {
                    return $this->readers[$extension]->read($path);
                }
                else
                {
                    throw new LoadException("No reader for '$extension' extension");
                }
            }
        }

        return null;
    }

}
