<?php

namespace Fastwf\Constraint\Build\Factory\OpenApi\Logical;

use Fastwf\Constraint\Constraints\Logic\OneOf;
use Fastwf\Constraint\Build\Factory\OpenApi\Logical\LAFactory;

/**
 * The 'oneOf' logical constraint factory.
 */
class OneOfFactory extends LAFactory
{

    public function __construct($environment)
    {
        parent::__construct('oneOf', $environment);
    }

    public function createConstraint(&$subConstraints)
    {
        return new OneOf(...$subConstraints);
    }

}
