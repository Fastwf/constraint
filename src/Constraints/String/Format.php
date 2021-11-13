<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Api\Constraint;

/**
 * Abstract class that allows to match predefined format.
 */
abstract class Format implements Constraint
{

    protected $format;

    /**
     * Constructor.
     *
     * @param string $format the format name
     */
    public function __construct($format)
    {
        $this->format = $format;
    }

    /**
     * Get the name of the constraint.
     *
     * @return string the name
     */
    protected function getName()
    {
        return 'format';
    }

}
