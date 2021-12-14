<?php

namespace Fastwf\Tests\Build\Environment;

use Fastwf\Constraint\Build\Environment\Environment;

/**
 * Implementation to use for tests
 */
class TestingEnvironment extends Environment
{

    public function loadSchema($schema, &$constraint)
    {

    }

}
