<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Utils\Range;
use Fastwf\Constraint\Constraints\String\Format;
/**
 * Format constraint that control time that match the RFC3339 "partial-time" format.
 * 
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class TimeFormat extends Format
{

    public function __construct()
    {
        parent::__construct('time');        
    }

    public function validate($node, $context)
    {
        $value = $node->get();
        $matches = [];

        // The value must respect :
        //      1 - The partial-time pattern
        return \preg_match("/^(\\d{2}):(\\d{2}):(\\d{2})(.(\\d+))?$/", $value, $matches) === 1
            //  2 - Check each portions
                && Range::inRange((int) $matches[1], 0, 23) // hour
                && Range::inRange((int) $matches[2], 0, 60) // minutes
                && Range::inRange((int) $matches[3], 0, 60) // seconds
            ? null
            : $context->violation($value, $this->getName(), ['format' => $this->format]);
    }

}
