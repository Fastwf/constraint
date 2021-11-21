<?php

namespace Fastwf\Tests\Constraints\String;

use Fastwf\Constraint\Data\Node;
use Fastwf\Tests\Constraints\ConstraintTestCase;
use Fastwf\Constraint\Constraints\String\BinaryFormat;

class BinaryFormatTest extends ConstraintTestCase
{

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\BinaryFormat
     */
    public function testValidate()
    {
        $constraint = new BinaryFormat();

        $this->assertNull($constraint->validate(Node::from(['value' => 'any']), $this->context));
    }

}