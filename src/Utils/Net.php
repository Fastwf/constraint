<?php

namespace Fastwf\Constraint\Utils;

/**
 * Utility class about network.
 */
class Net
{

    /**
     * Domain regex pattern.
     */
    public const DOMAIN = "(?:[a-z0-9](?:[-a-z0-9]*[a-z0-9])?\.)*[a-z0-9](?:[-a-z0-9]*[a-z0-9])?";

    /**
     * IP v4 regex pattern.
     * 
     * Warning: do not check integer values.
     */
    public const IP_V4 = "((?:\d{1,3}\.){3}\d{1,3})";

    /**
     * IP v6 regex pattern.
     * 
     * Warning: do not check hexa values.
     */
    public const IP_V6 = "((?:[a-e0-9]{0,4}:){2,7}[a-e0-9]{0,4})";

    /**
     * Check if the domain provided is a valid hostname.
     *
     * @param string $domain the domain to check
     * @return boolean true when the hostname is a valid domain name
     */
    public static function isHostname($domain)
    {
        return \preg_match('/^' . self::DOMAIN . '$/i', $domain) === 1;
    }

    /**
     * Check if the value provided is a valid ip v4.
     *
     * @param string $value the sequence to test
     * @return boolean true when the value is a valid IP v4
     */
    public static function isIPv4($value)
    {
        return \preg_match(self::IP_V4, $value) === 1
            && \inet_pton($value) !== false;
    }

    /**
     * Check if the value provided is a valid ip v6.
     *
     * @param string $value the sequence to test
     * @return boolean true when the value is a valid IP v6
     */
    public static function isIPv6($value)
    {
        return \preg_match(self::IP_V6, $value) === 1
            && \inet_pton($value) !== false;
    }

}