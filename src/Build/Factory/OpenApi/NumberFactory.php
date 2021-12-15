<?php

namespace Fastwf\Constraint\Build\Factory\OpenApi;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Constraints\Chain;
use Fastwf\Constraint\Constraints\Number\Maximum;
use Fastwf\Constraint\Constraints\Number\Minimum;
use Fastwf\Constraint\Constraints\Type\DoubleType;
use Fastwf\Constraint\Constraints\Number\MultipleOf;
use Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory;

/**
 * Allows to create constraint to validate number type (double).
 */
class NumberFactory extends AnyFactory
{

    protected function createType($schema)
    {
        $constraints = [];

        $this->addMinimumConstraint($schema, $constraints);
        $this->addMaximumConstraint($schema, $constraints);
        $this->addMultipleOf($schema, $constraints);

        $constraint = $this->getTypeConstraint();
        if (!empty($constraints))
        {
            $constraint = new Chain(
                true,
                $constraint,
                new Chain(
                    false,
                    ...$constraints,
                ),
            );
        }

        return $constraint;
    }

    /**
     * Get the constraint type.
     *
     * @return Constraint the type constraint
     */
    protected function getTypeConstraint()
    {
        return new DoubleType();
    }

    /**
     * Add the minimum constraint when it's set in schema.
     *
     * @param array $schema the schema specification to use to create the constraint.
     * @param array $constraints the array of constraint to populate
     * @return void
     */
    protected function addMinimumConstraint($schema, &$constraints)
    {
        if (\array_key_exists('minimum', $schema))
        {
            $constraints[] = new Minimum(
                $schema['minimum'],
                \array_key_exists('exclusiveMinimum', $schema) && $schema['exclusiveMinimum'],
            );
        }
    }

    /**
     * Add the maximum constraint when it's set in schema.
     *
     * @param array $schema the schema specification to use to create the constraint.
     * @param array $constraints the array of constraint to populate
     * @return void
     */
    protected function addMaximumConstraint($schema, &$constraints)
    {
        if (\array_key_exists('maximum', $schema))
        {
            $constraints[] = new Maximum(
                $schema['maximum'],
                \array_key_exists('exclusiveMaximum', $schema) && $schema['exclusiveMaximum'],
            );
        }
    }

    /**
     * Add the multiple of constraint when it's set in schema.
     *
     * @param array $schema the schema specification to use to create the constraint.
     * @param array $constraints the array of constraint to populate
     * @return void
     */
    protected function addMultipleOf($schema, &$constraints)
    {
        if (\array_key_exists('multipleOf', $schema))
        {
            $constraints[] = new MultipleOf($schema['multipleOf']);
        }
    }

}
