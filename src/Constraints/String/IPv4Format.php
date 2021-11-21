<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Utils\Net;
use Fastwf\Constraint\Constraints\String\Format;

/**
 * IP v4 format constraint.
 *
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class IPv4Format extends Format
{

    public function __construct()
    {
        parent::__construct('ipv4');
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        return Net::isIPv4($value)
            ? null
            : $context->violation($value, $this->getName(), ['format' => $this->format]);
    }

}
