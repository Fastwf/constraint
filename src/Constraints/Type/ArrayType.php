<?php

namespace Fastwf\Constraint\Constraints\Type;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Constraints\Type\Type;
use Fastwf\Constraint\Data\ViolationConstraint;

/**
 * Type constraint validation for array as list.
 */
class ArrayType extends Type
{

    public function __construct() {
        // validate method is overriden by this calss.
        //  So is not necessary to call the parent constructor that setup the parent::validate
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        $isList = \gettype($value) === 'array';
        // Check value index as sequential
        if ($isList)
        {
            $expectedIndex = 0;
            foreach (\array_keys($value) as $index)
            {
                // Check the index value and type
                if ($expectedIndex !== $index)
                {
                    $isList = false;
                    break;
                }
                $expectedIndex++;
            }
        }

        return $isList
            ? null
            : $context->violation($value, $this->getName(), ['type' => 'array']);
    }

}
