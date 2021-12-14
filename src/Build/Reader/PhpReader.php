<?php

namespace Fastwf\Constraint\Build\Reader;

use Fastwf\Constraint\Build\Reader\IReader;

/**
 * Reader implementation that load a source file using the require() php function.
 */
class PhpReader implements IReader
{

    public function read($path)
    {
        return require($path);
    }

}
