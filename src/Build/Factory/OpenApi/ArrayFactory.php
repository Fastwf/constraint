<?php

namespace Fastwf\Constraint\Build\Factory\OpenApi;

use Fastwf\Constraint\Constraints\Chain;
use Fastwf\Constraint\Constraints\Type\ArrayType;
use Fastwf\Constraint\Constraints\Arrays\MaxItems;
use Fastwf\Constraint\Constraints\Arrays\MinItems;
use Fastwf\Constraint\Constraints\Arrays\UniqueItems;
use Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory;

/**
 * ArrayFactory constraint factory.
 */
class ArrayFactory extends AnyFactory
{

    protected function createType($schema)
    {
        $constraints = [];

        // Add array constraints
        $this->addChildSchemaConstraint($schema, $constraints);
        $this->addMinItems($schema, $constraints);
        $this->addMaxItems($schema, $constraints);
        $this->addUniqueItems($schema, $constraints);

        // Setup minimal constraints according to schema constraints
        $constraint = new ArrayType();
        if (!empty($constraints))
        {
            $constraint = new Chain(
                true,
                $constraint,
                new Chain(false, ...$constraints)
            );
        }

        return $constraint;
    }

    /**
     * Add the min items constraint when it's set in schema.
     *
     * @param array $schema the schema specification to use to create the constraint.
     * @param array $constraints the array of constraint to populate.
     * @return void
     */
    protected function addMinItems($schema, &$constraints)
    {
        if (\array_key_exists('minItems', $schema))
        {
            $constraints[] = new MinItems($schema['minItems']);
        }
    }

    /**
     * Add the max items of constraint when it's set in schema.
     *
     * @param array $schema the schema specification to use to create the constraint.
     * @param array $constraints the array of constraint to populate.
     * @return void
     */
    protected function addMaxItems($schema, &$constraints)
    {
        if (\array_key_exists('maxItems', $schema))
        {
            $constraints[] = new MaxItems($schema['maxItems']);
        }
    }

    /**
     * Add the unique items constraint when it's set in schema.
     *
     * @param array $schema the schema specification to use to create the constraint.
     * @param array $constraints the array of constraint to populate.
     * @return void
     */
    protected function addUniqueItems($schema, &$constraints)
    {
        if (\array_key_exists('uniqueItems', $schema) && $schema['uniqueItems'])
        {
            $constraints[] = new UniqueItems();
        }
    }

    /**
     * Add the constraints for items.
     *
     * @param array $schema the schema specification to use to create the constraint.
     * @param array $constraints the array of constraint to populate.
     * @return void
     */
    protected function addChildSchemaConstraint($schema, &$constraints)
    {
        if (\array_key_exists('items', $schema))
        {
            $length = \array_push($constraints, null);
            $this->environment->loadSchema($schema['items'], $constraints[$length - 1]);
        }
    }

}
