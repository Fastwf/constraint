<?php

namespace Fastwf\Tests\Api;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Data\Violation;
use Fastwf\Constraint\Api\ViolationIterator;
use Fastwf\Constraint\Data\ViolationConstraint;
use Fastwf\Constraint\Api\SimpleTemplateProvider;

class ViolationIteratorTest extends TestCase
{
    
    /**
     * @covers Fastwf\Constraint\Api\SimpleTemplateProvider
     * @covers Fastwf\Constraint\Api\ViolationIterator
     * @covers Fastwf\Constraint\Data\Violation
     * @covers Fastwf\Constraint\Data\ViolationConstraint
     */
    public function testIterate()
    {
        $provider = new SimpleTemplateProvider();
        $provider->setTemplate('type', 'Expected %{type} type');
        $provider->setTemplate('required', 'The value is required');

        $it = new ViolationIterator($provider);

        $violation = new Violation(null, [new ViolationConstraint('type', ['type' => 'object'])]);
        $children = &$violation->getChildren();
        $children['name'] = new Violation(null, [new ViolationConstraint('required', [])]);
        $children['age'] = new Violation(null, [new ViolationConstraint('type', ['type' => 'int'])]);

        $it->iterate($violation);

        $this->assertEquals('Expected object type', $violation->getViolations()[0]->getMessage());
        $this->assertEquals('The value is required', $violation->getChildren()['name']->getViolations()[0]->getMessage());
        $this->assertEquals('Expected int type', $violation->getChildren()['age']->getViolations()[0]->getMessage());
    }

}