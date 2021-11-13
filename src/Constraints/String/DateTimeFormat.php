<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Constraints\String\Format;
/**
 * Format constraint that control date time that match the RFC3339 "date-time" format.
 * 
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class DateTimeFormat extends Format
{

    private const PATTERN = "/^(\\d{4})-(\\d{2})-(\\d{2})T(\\d{2}):(\\d{2}):(\\d{2})(.(\\d+))?(Z|[+-]\\d{2}:\\d{2})$/i";

    public function __construct()
    {
        parent::__construct('date-time');        
    }

    public function validate($node, $context)
    {
        $value = $node->get();
        $matches = [];

        // The value must respect :
        //      1 - The pattern (self::PATTERN)
        return \preg_match(self::PATTERN, $value, $matches) === 1
            //  2 - Date and time exists
                && \checkdate((int) $matches[2], (int) $matches[3], (int) $matches[1])
                && self::inRange((int) $matches[4], 0, 23) // hour
                && self::inRange((int) $matches[5], 0, 60) // minutes
                && self::inRange((int) $matches[6], 0, 60) // seconds
            //  3 - The time-offset is valid (Z) or +/- valid duration
                && (\strtoupper($matches[9]) === 'Z'
                    || self::inRange((int) \substr($matches[9], 1, 2), 0, 24) && self::inRange((int) \substr($matches[9], 3, 2), 0, 60))
            ? null
            : $context->violation($value, $this->getName(), ['format' => $this->format]);
    }

    /**
     * Check if the value is in the range [$start; $end[.
     * 
     * @param int $value the value to check
     * @param int $start the start of the range
     * @param int $end the end of the range excluded
     * @return boolean true when the value is in the range
     */
    private static function inRange($value, $start, $end)
    {
        return $value >= $start && $value < $end;
    }

}
