<?php

namespace Fastwf\Constraint\Build\Factory;

use Fastwf\Constraint\Api\Constraint;

/**
 * Factory definition that create a constraint from a schema.
 */
interface IFactory
{

    /**
     * Generate the constraint according to the schema specifications.
     *
     * @param array $schema the schema specification to use to create the constraint
     * @return Constraint the constraint generated
     */
    public function create($schema);

}
