<?php

namespace Fastwf\Constraint\Build\Factory\OpenApi\Logical;

use Fastwf\Constraint\Constraints\Logic\Not;
use Fastwf\Constraint\Build\Factory\LogicalFactory;

/**
 * The 'not' logical constraint factory.
 */
class NotFactory extends LogicalFactory
{

    public function __construct($environment)
    {
        parent::__construct('not', $environment);
    }

    public function createConstraint(&$subConstraints)
    {
        return new Not(...$subConstraints);
    }

    public function &createSubConstraints($schema)
    {
        $subConstraint = null;
        $this->environment->loadSchema($schema[$this->name], $subConstraint);

        $constraints = [&$subConstraint];
        return $constraints;
    }

}
