<?php

namespace Fastwf\Constraint\Build\Reader;

/**
 * Reader definition that allows to read a source file and return the parsed schema.
 */
interface IReader
{

    /**
     * Load a schema from the given path.
     *
     * @param mixed $path the file path to read to generate the schema model.
     * @return array the schema array
     */
    public function read($path);

}
