<?php

namespace Fastwf\Tests\Constraints\String;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Api\ValidationContext;
use Fastwf\Constraint\Constraints\String\MinLength;

class MinLengthTest extends TestCase
{

    private $context;

    protected function setUp(): void
    {
        $this->context = new ValidationContext(null, null);
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Length
     * @covers Fastwf\Constraint\Constraints\String\MinLength
     */
    public function testValidate()
    {
        $constraint = new MinLength(5);

        $this->assertNull($constraint->validate(
            Node::from(['value' => 'tests']),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Length
     * @covers Fastwf\Constraint\Constraints\String\MinLength
     */
    public function testValidateError()
    {
        $constraint = new MinLength(5);

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => 'test']),
            $this->context,
        ));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Constraints\String\Length
     * @covers Fastwf\Constraint\Constraints\String\MinLength
     */
    public function testValidateUtf8()
    {
        $constraint = new MinLength(5);

        $this->assertNotNull($constraint->validate(
            Node::from(['value' => 'étés']),
            $this->context,
        ));
    }

}
