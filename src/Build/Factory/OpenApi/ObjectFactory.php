<?php

namespace Fastwf\Constraint\Build\Factory\OpenApi;

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
                $constraint = null;
                $this->environment->loadSchema($childSchema, $constraint);

                // Wrap the constraint into Required constraint
                $isRequired = \in_array($property, $required);
                $propertiesOptions[$property] = new Required($isRequired, $constraint);

                // Remove the property 
                if ($isRequired)
                {
                    unset($required[\array_search($property)]);
                }
            }
            // Add required properties constraint for missing properties
            foreach ($required as $property) {
                $propertiesOptions[$property] = new Required(true);
            }

            $options['properties'] = $propertiesOptions;
        }

        // Create final constraint including or not other safe constraints
        $constraint = new ObjectType();
        if (!empty($options))
        {
            $constraint = new Chain(
                true,
                $constraint,
                new Schema($options),
            );
        }

        return $constraint;
    }

}
