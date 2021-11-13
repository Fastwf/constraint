<?php

namespace Fastwf\Constraint\Utils;

/**
 * Utility class providing methods about range.
 */
class Range
{

    /**
     * Check if the value is in the range [$start; $end[.
     * 
     * @param int $value the value to check
     * @param int $start the start of the range
     * @param int $end the end of the range excluded
     * @return boolean true when the value is in the range
     */
    public static function inRange($value, $start, $end)
    {
        return $value >= $start && $value < $end;
    }

}
