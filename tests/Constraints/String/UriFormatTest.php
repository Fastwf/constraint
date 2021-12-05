<?php

namespace Fastwf\Tests\Constraints\String;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\String\UriFormat;

class UriFormatTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\UriFormat
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testValidate()
    {
        $constraint = new UriFormat();

        $uris = [
            'ftp://ftp.is.co.za/rfc/rfc1808.txt',
            'http://www.ietf.org/rfc/rfc2396.txt',
            'https://localhost:8000/path/to/page.php?arg1=foo&arg2=bar#hash',
            'https://user:password@dns.com/path',
            'ldap://[2001:db8::7]/c=GB?objectClass?one',
            'mailto:John.Doe@example.com',
            'news:comp.infosystems.www.servers.unix',
            'tel:+1-816-555-1212',
            'telnet://192.0.2.16:80/',
            'urn:oasis:names:specification:docbook:dtd:xml:4.1.2',
        ];

        foreach ($uris as $uri) {
            $this->assertNull($constraint->validate(Node::from(['value' => $uri]), $this->context));
        }
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\UriFormat
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testValidateError()
    {
        $constraint = new UriFormat();

        $uris = [
            'invalid', // no scheme
            'http://-invalid.dns', // invalid DNS
            'https://user:pas/sw:=ord?!@dns.com/path', // Parse uri result is false
        ];

        foreach ($uris as $uri) {
            $this->assertNotNull($constraint->validate(Node::from(['value' => $uri]), $this->context));
        }
    }

}
