<?php

namespace Fastwf\Constraint\Constraints\Type;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Constraints\Type\Type;
use Fastwf\Constraint\Data\ViolationConstraint;

/**
 * Type constraint validation for array as list.
 */
class ListType extends Type
{

    public function __construct() {}

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
            : $context->violation($value, $this->getName(), ['type' => 'list']);
    }

}
