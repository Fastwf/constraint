<?php

namespace Fastwf\Constraint\Constraints\Objects;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Data\Violation;
use Fastwf\Constraint\Constraints\Required;

/**
 * Constraint validation for object type.
 */
class Schema implements Constraint
{

    /**
     * The array containing property constraint.
     *
     * @var array
     */
    private $properties;

    /**
     * The value constraint of unreferenced properties.
     *
     * @var Constraint
     */
    private $additionalProperties;

    /**
     * The minimum number of properties of the object.
     *
     * @var int
     */
    private $minProperties;

    /**
     * The maximum number of properties of the object.
     *
     * @var int|null
     */
    private $maxProperties;

    /**
     * Constructor.
     * 
     * The option array must respect the next definition
     * - 'properties': (optional) the list of property constraints
     * - 'minProperties': (optional) the minimum number of properties of the object.
     * - 'maxProperties': (optional) the maximum number of properties of the object.
     * - 'additionalProperties': (optional) the constraint of unknown properties (by default no constraints)
     *
     * @param array $options the schema constraint validation options
     */
    public function __construct($options)
    {
        $this->properties = \array_key_exists('properties', $options) ? $options['properties'] : [];
        $this->minProperties = \array_key_exists('minProperties', $options) ? $options['minProperties'] : 0;
        $this->maxProperties = \array_key_exists('maxProperties', $options) ? $options['maxProperties'] : null;

        // Setup 'additionalProperties' using option reference
        if (\array_key_exists('additionalProperties', $options))
        {
            $this->additionalProperties = &$options['additionalProperties'];
        }
        else
        {
            $this->additionalProperties = null;
        }
    }

    public function validate($node, $context)
    {
        // Create local array copy
        $cProperties = $this->properties;

        $objectContext = $context->getSubContext($node);        
        $objectViolation = null;
        $value = $node->get();

        // Iterate on node properties to count properties and validate values
        $propertiesCount = 0;
        foreach ($node as $property => $childNode) {
            if (\array_key_exists($property, $cProperties))
            {
                // Use the property validation
                $this->validateChildValue(
                    $cProperties[$property],
                    $objectViolation,
                    $childNode,
                    $value,
                    $property,
                    $objectContext
                );

                // Remove the property to iterate only on missing properties
                unset($cProperties[$property]);
            } else if ($this->additionalProperties !== null) {
                // Use the additional property validation
                $this->validateChildValue(
                    $this->additionalProperties,
                    $objectViolation,
                    $childNode,
                    $value,
                    $property,
                    $objectContext
                );
            }
            
            $propertiesCount++;
        }

        // Iterate on missing properties to check validation for required properties
        foreach ($cProperties as $property => $constraint) {
            if ($constraint instanceof Required)
            {
                // If the constraint is not a Required instance this will result probably on error.
                //  The reason is that the value delivered by node will be null.
                $violation = $constraint->validate($node->{$property}, $objectContext);
    
                if ($violation !== null)
                {
                    $this->setChildViolation($objectViolation, $value, $property, $violation);
                }
            }
        }

        if ($this->minProperties > $propertiesCount)
        {
            // the minimum of properties constraint is not respected
            $objectViolation = $context->violation(
                $value,
                'minProperties',
                ['properties' => $this->minProperties, 'actual' => $propertiesCount],
                $objectViolation
            );
        }
        if ($this->maxProperties !== null && $this->maxProperties < $propertiesCount)
        {
            // the maximum of properties constraint is not respected
            $objectViolation = $context->violation(
                $value,
                'maxProperties',
                ['properties' => $this->maxProperties, 'actual' => $propertiesCount],
                $objectViolation
            );
        }

        return $objectViolation;
    }

    protected function validateChildValue($constraint, &$objectViolation, $childNode, $value, $property, $objectContext) {
        $violation = $constraint->validate($childNode, $objectContext);
        if ($violation !== null)
        {
            $this->setChildViolation($objectViolation, $value, $property, $violation);
        }
    }

    /**
     * Create or update the violation object and inject the child property violation.
     *
     * @param Violation $violation the parent violation object (provided by reference)
     * @param object|array $value the parent value
     * @param string $property the property name associated to $propertyViolation
     * @param Violation $propertyViolation the child property violation
     * @return void
     */
    protected function setChildViolation(&$violation, $value, $property, $propertyViolation)
    {
        if ($violation === null)
        {
            // Provide the violation using reference parameter
            $violation = new Violation($value);
        }

        $violation->getChildren()[$property] = $propertyViolation;
    }

}
