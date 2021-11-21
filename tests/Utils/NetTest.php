<?php

namespace Fastwf\Tests\Utils;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Utils\Net;

class NetTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testIsHostname()
    {
        $this->assertTrue(Net::isHostname('test.fr'));
    }

    /**
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testIsNotHostname()
    {
        $this->assertFalse(Net::isHostname('-test.fr'));
    }

    /**
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testIsIpV4()
    {
        $this->assertTrue(Net::isIPv4('127.0.0.1'));
    }

    /**
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testIsNotIpV4()
    {
        $this->assertFalse(Net::isIPv4('test.fr'));
    }

    /**
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testIsIpV6()
    {
        $this->assertTrue(Net::isIPv6('::1'));
    }

    /**
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testIsNotIpV6()
    {
        $this->assertFalse(Net::isIPv6('127.0.0.1'));
    }

}
