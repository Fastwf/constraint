<?php

namespace Fastwf\Tests\Constraints\String;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Api\ValidationContext;
use Fastwf\Constraint\Constraints\String\ByteFormat;

class ByteFormatTest extends TestCase
{

    private $context;

    protected function setUp(): void
    {
        $this->context = new ValidationContext(null, null);
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\PcreFormat
     * @covers Fastwf\Constraint\Constraints\String\ByteFormat
     */
    public function testValidate()
    {
        $constraint = new ByteFormat();

        $this->assertNull($constraint->validate(Node::from(['value' => 'SGVsbG8gd29ybGQhIQ+/']), $this->context));
    }
    
    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Format
     * @covers Fastwf\Constraint\Constraints\String\PcreFormat
     * @covers Fastwf\Constraint\Constraints\String\ByteFormat
     */
    public function testValidateErrors()
    {
        $constraint = new ByteFormat();

        $this->assertNotNull($constraint->validate(Node::from(['value' => 'SGVsbG8gd29ybGQhIQ-_']), $this->context));
    }

}