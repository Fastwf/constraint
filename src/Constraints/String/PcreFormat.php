<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Constraints\String\Format;

/**
 * Base class that implement validation based on pattern control.
 */
abstract class PcreFormat extends Format
{

    protected $pattern;

    /**
     * Constructor.
     *
     * @param string $format the format name
     * @param string $pattern the regex pattern to use with preg_match
     */
    public function __construct($format, $pattern)
    {
        parent::__construct($format);

        $this->pattern = $pattern;
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        return \preg_match($this->pattern, $value) === 1
            ? null
            : $context->violation($value, $this->getName(), ['format' => $this->format]);
    }

}
