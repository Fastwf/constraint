<?php

namespace Fastwf\Tests\Api;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Api\Validator;
use Fastwf\Constraint\Constraints\Type\IntegerType;

class ValidatorTest extends TestCase
{

    /**
     * @covers Fastwf\Constraint\Api\SimpleTemplateProvider
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateTrue()
    {
        $validator = new Validator(new IntegerType());

        $this->assertTrue($validator->validate(10));
    }

    /**
     * @covers Fastwf\Constraint\Api\SimpleTemplateProvider
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testValidateFalse()
    {
        $validator = new Validator(new IntegerType());

        $this->assertFalse($validator->validate(3.14));
    }

    /**
     * @covers Fastwf\Constraint\Api\SimpleTemplateProvider
     * @covers Fastwf\Constraint\Api\Validator
     * @covers Fastwf\Constraint\Api\ValidationContext
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     * @covers Fastwf\Constraint\Constraints\Type\Type
     * @covers Fastwf\Constraint\Constraints\Type\IntegerType
     */
    public function testGetViolations()
    {
        $validator = new Validator(new IntegerType());
        $validator->validate(3.14);

        $this->assertNotNull(
            $validator->getViolations()->getViolations()[0]->getMessage(),
        );
    }

}
