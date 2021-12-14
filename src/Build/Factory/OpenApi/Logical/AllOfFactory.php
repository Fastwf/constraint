<?php

namespace Fastwf\Constraint\Build\Factory\OpenApi\Logical;

use Fastwf\Constraint\Constraints\Logic\AllOf;
use Fastwf\Constraint\Build\Factory\OpenApi\Logical\LAFactory;

/**
 * The 'allOf' logical constraint factory.
 */
class AllOfFactory extends LAFactory
{

    public function __construct($environment)
    {
        parent::__construct('allOf', $environment);
    }

    public function createConstraint(&$subConstraints)
    {
        return new AllOf(...$subConstraints);
    }

}
