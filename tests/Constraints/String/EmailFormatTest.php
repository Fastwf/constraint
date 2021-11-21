<?php

namespace Fastwf\Tests\Constraints\String;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\String\EmailFormat;

class EmailFormatTest extends ConstraintTestCase
{

    private const SOURCE = [
        ['email' => 'simple@example.com', 'expected' => true],
        ['email' => 'very.common@example.com', 'expected' => true],
        ['email' => 'disposable.style.email.with+symbol@example.com', 'expected' => true],
        ['email' => 'other.email-with-hyphen@example.com', 'expected' => true],
        ['email' => 'fully-qualified-domain@example.com', 'expected' => true],
        ['email' => 'user.name+tag+sorting@example.com', 'expected' => true],
        ['email' => 'x@example.com', 'expected' => true],
        ['email' => 'example-indeed@strange-example.com', 'expected' => true],
        ['email' => 'test/test@test.com', 'expected' => true],
        ['email' => 'admin@mailserver1', 'expected' => true],
        ['email' => 'example@s.example', 'expected' => true],
        ['email' => '" "@example.org', 'expected' => true],
        ['email' => '"john..doe"@example.org', 'expected' => true],
        ['email' => 'mailhost!username@example.org', 'expected' => true],
        ['email' => 'user%example.com@example.org', 'expected' => true],
        ['email' => 'user-@example.org', 'expected' => true],
        ['email' => 'jsmith@[192.168.2.1]', 'expected' => true],
        ['email' => 'jsmith@[2001:db8::1]', 'expected' => true],
        ['email' => 'Abc.example.com', 'expected' => false],
        ['email' => 'A@b@c@example.com', 'expected' => false],
        ['email' => 'a"b(c)d,e:f;g<h>i[j\k]l@example.com', 'expected' => false],
        ['email' => 'just"not"right@example.com', 'expected' => false],
        ['email' => 'this is"not\allowed@example.com', 'expected' => false],
        ['email' => 'this\ still\"not\\allowed@example.com', 'expected' => false],
        ['email' => '1234567890123456789012345678901234567890123456789012345678901234+x@example.com', 'expected' => false],
        ['email' => 'i_like_underscore@but_its_not_allowed_in_this_part.example.com', 'expected' => false],
        ['email' => 'QA[icon]CHOCOLATE[icon]@test.com', 'expected' => false],
    ];

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\EmailFormat
     * @covers Fastwf\Constraint\Utils\Net
     */
    public function testValidate()
    {
        $constraint = new EmailFormat();

        foreach (self::SOURCE as $data) {
            $node = Node::from(['value' => $data['email']]);

            if ($data['expected'])
            {
                $this->assertNull($constraint->validate($node, $this->context));
            }
            else
            {
                $this->assertNotNull($constraint->validate($node, $this->context));
            }
        }
    }

}
