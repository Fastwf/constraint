<?php

namespace Fastwf\Constraint\Build\Factory\OpenApi;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Constraints\Chain;
use Fastwf\Constraint\Constraints\Required;
use Fastwf\Constraint\Constraints\Objects\Schema;
use Fastwf\Constraint\Constraints\Type\ObjectType;
use Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory;

/**
 * ObjectFactory constraint factory.
 */
class ObjectFactory extends AnyFactory
{

    protected function createType($schema)
    {
        $options = [];

        // Add min and max properties 
        if (\array_key_exists('minProperties', $schema))
        {
            $options['minProperties'] = $schema['minProperties'];
        }
        if (\array_key_exists('maxProperties', $schema))
        {
            $options['maxProperties'] = $schema['maxProperties'];
        }
        
        // Add additional properties constraints
        if (\array_key_exists('additionalProperties', $schema))
        {
            $additionalProperties = $schema['additionalProperties'];

            if (\gettype($additionalProperties) === 'array' && !empty($additionalProperties))
            {
                $this->environment->loadSchema($additionalProperties, $options['additionalProperties']);
            }
        }

        // Add constraint for each defined properties
        $required = \array_key_exists('required', $schema) ? $schema['required'] : [];
        $properties = \array_key_exists('properties', $schema) ? $schema['properties'] : [];

        if (!empty($required) || !empty($properties))
        {
            $propertiesOptions = [];
            foreach ($properties as $property => $childSchema) {
                $propertiesOptions[$property] = $this->createPropertyConstraint(
                    $required,
                    $property,
                    $childSchema
                );
            }
            // Add required properties constraint for missing properties
            foreach ($required as $property) {
                $propertiesOptions[$property] = new Required(true);
            }

            $options['properties'] = $propertiesOptions;
        }

        // Create final constraint including or not other safe constraints
        $outConstraint = new ObjectType();
        if (!empty($options))
        {
            $outConstraint = new Chain(
                true,
                $outConstraint,
                new Schema($options),
            );
        }

        return $outConstraint;
    }

    /**
     * Create the child property constraint according to the child schema.
     *
     * @param array $required the list of required properties
     * @param string $property the child property name
     * @param array $childSchema the child schema
     * @return Constraint the corresponding constraint
     */
    private function createPropertyConstraint(&$required, $property, $childSchema)
    {
        $constraint = null;
        $this->environment->loadSchema($childSchema, $constraint);

        // Wrap the constraint into Required constraint
        $isRequired = \in_array($property, $required);
        $reqConstraint = new Required($isRequired, $constraint);

        // Remove the property 
        if ($isRequired)
        {
            unset($required[\array_search($property, $required)]);
        }

        return $reqConstraint;
    }

}
