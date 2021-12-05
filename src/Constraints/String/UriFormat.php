<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Utils\Net;
use Fastwf\Constraint\Constraints\String\Format;

/**
 * Format validation for uri strings. This constraint control the uri according to RFC3986 specifications.
 * 
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class UriFormat extends Format
{

    public function __construct()
    {
        parent::__construct('uri');
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        $result = \parse_url($value);

        return $result !== false && \array_key_exists('scheme', $result) && $this->validateHost($result)
            ? null
            : $context->violation($value, $this->getName(), [$this->getName() => $this->format]);
    }

    private function validateHost($parserResult)
    {
        if (\array_key_exists('host', $parserResult))
        {
            // Check if the host is valid (hostname, ipv4, ipv6, [ipv4] or [ipv6])
            $matches = [];
            if (\preg_match('/^\[([^\]]*)\]$/', $parserResult['host'], $matches))
            {
                $host = $matches[1];
            }
            else
            {
                $host = $parserResult['host'];
            }

            return Net::isIPv4($host) || Net::isIPv6($host) || Net::isHostname($host);
        }
        else
        {
            return true;
        }
    }

}
