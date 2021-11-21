<?php

namespace Fastwf\Tests\Constraints;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Api\ValidationContext;

/**
 * Base class that allows to define the validation context on setup.
 */
class ConstraintTestCase extends TestCase
{

    protected $context;

    protected function setUp(): void
    {
        $this->context = new ValidationContext(null, null);
    }

}
