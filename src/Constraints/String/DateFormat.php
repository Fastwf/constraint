<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Constraints\String\Format;

/**
 * Format constraint that control date that match the RFC3339 "full-date" format.
 * 
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class DateFormat extends Format
{

    public function __construct()
    {
        parent::__construct('date');        
    }

    public function validate($node, $context)
    {
        $value = $node->get();
        $matches = [];

        // The date must respect:
        //      1 - The "full-date" pattern
        return \preg_match("/^(\\d{4})-(\\d{2})-(\\d{2})$/", $value, $matches) === 1
            //  2 - The date exists
                && \checkdate((int) $matches[2], (int) $matches[3], (int) $matches[1])
            ? null
            : $context->violation($value, $this->getName(), ['format' => $this->format]);
    }

}
