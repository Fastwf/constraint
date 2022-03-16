<?php

namespace Fastwf\Constraint\Reflection;

use Fastwf\Constraint\Data\Node;

/**
 * Reflection property API to use to simplify object property access.
 */
abstract class Property
{

    /**
     * Indicate if the property exists or not in read mode.
     *
     * @return boolean true if the property is defined and accessible.
     */
    public abstract function isReadable();

    /**
     * Allows to access to the value.
     *
     * @return Node the value hold by object property.
     */
    public abstract function get($object);

    public abstract function set($object, $value);

    /**
     * Create an instance of Property class to access to the property $name.
     *
     * @param \ReflectionClass $classReflection the class reflection of the object holding the property $name.
     * @param string $name the property name to access.
     * @return Property the property accessor.
     */
    public static function getInstance($classReflection, $name)
    {
        if ($classReflection->hasProperty($name))
        {
            $property = $classReflection->getProperty($name);

            if ($property->isPublic())
            {
                $instance = new PublicProperty($property);
            }
            else
            {
                $instance = new StdProperty($classReflection, $property);
            }
        }
        else
        {
            // Create standard property to try to access to the private variables of parent classes
            $instance = new StdProperty($classReflection, null, $name);
        }

        return $instance;
    }

}
