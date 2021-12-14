<?php

namespace Fastwf\Constraint\Build\Factory\OpenApi\Logical;

use Fastwf\Constraint\Constraints\Logic\AnyOf;
use Fastwf\Constraint\Build\Factory\OpenApi\Logical\LAFactory;

/**
 * The 'anyOf' logical constraint factory.
 */
class AnyOfFactory extends LAFactory
{

    public function __construct($environment)
    {
        parent::__construct('anyOf', $environment);
    }

    public function createConstraint(&$subConstraints)
    {
        return new AnyOf(...$subConstraints);
    }

}
