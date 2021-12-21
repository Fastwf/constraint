<?php

namespace Fastwf\Constraint\Reflection;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Reflection\Method;
use Fastwf\Constraint\Reflection\IMethod;
use Fastwf\Constraint\Reflection\Property;
use Fastwf\Constraint\Reflection\UndefinedGetterMethod;
use Fastwf\Constraint\Reflection\UndefinedSetterMethod;

class StdProperty extends Property
{
    
    private $name;
    private $reflection;

    private $getter = null;
    private $setter = null;

    /**
     * Constructor.
     * 
     * $property parameter have higher priority than $name
     *
     * @param ReflectionClass $reflection the reflection class instance
     * @param ReflectionProperty|null $property the reflection property instance or null
     * @param string|null $name the name of the property or null
     */
    public function __construct($reflection, $property, $name = null)
    {
        $this->reflection = $reflection;

        // Access to the property name and upper the first letter (when alpha)
        //  $property parameter have higher priority than $name
        if ($property === null) {
            $this->name = $name;
        }
        else
        {
            $this->name = $property->getName();
        }
    }

    /**
     * Search the getter method when it's required and return the getter method.
     *
     * @return IMethod a getter method
     */
    private function getter()
    {
        if ($this->getter === null)
        {
            $propName = $this->name;
            
            // 1 - Search for public method with the same name as the property
            // 2 - Search for convention getter method name
            $suffix = \strtoupper($propName[0]) . \substr($propName, 1, \strlen($propName) - 1);
            foreach ([$propName, "get$suffix", "is$suffix", "has$suffix"] as $methodName) {
                if ($this->reflection->hasMethod($methodName))
                {
                    $method = $this->reflection->getMethod($methodName);
                    
                    if ($method->isPublic())
                    {
                        $this->getter = new Method($method);
                        break;
                    }
                }
            }

            // 3 - It's impossible to access to the property using method, so return an empty Node
            if ($this->getter === null)
            {
                $this->getter = new UndefinedGetterMethod();
            }
        }

        return $this->getter;
    }

    public function isReadable()
    {
        return !($this->getter() instanceof UndefinedGetterMethod);
    }

    public function get($object)
    {
        return $this->getter()->invoke($object);
    }

    public function set($object, $value)
    {
        if ($this->setter === null)
        {
            $propName = $this->name;
            // 1 - Verify that the setter exists and it's an accessible method
            $methodName = "set" . \strtoupper($propName[0]) . \substr($propName, 1, \strlen($propName) - 1);

            if ($this->reflection->hasMethod($methodName))
            {
                $method = $this->reflection->getMethod($methodName);
                
                if ($method->isPublic())
                {
                    $this->setter = new Method($method);
                }
            }

            // 2 - If the setter is not found use UndefinedSetterMethod
            if ($this->setter === null)
            {
                $this->setter = new UndefinedSetterMethod();
            }
        }

        $this->setter->invoke($object, $value);
    }

}
