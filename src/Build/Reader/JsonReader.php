<?php

namespace Fastwf\Constraint\Build\Reader;

use Fastwf\Constraint\Build\Reader\IReader;

/**
 * Reader implementation that load a source file using the json_decode php function.
 */
class JsonReader implements IReader
{

    public function read($path)
    {
        return \json_decode(
            \file_get_contents($path)
        );
    }

}
