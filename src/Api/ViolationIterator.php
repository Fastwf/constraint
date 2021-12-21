<?php

namespace Fastwf\Constraint\Api;

use Fastwf\Constraint\Data\Violation;
use Fastwf\Constraint\Api\TemplateProvider;
use Fastwf\Interpolation\StringInterpolator;

/**
 * Iterator that allows to inspect all violation to inject the error message inerpolated.
 */
class ViolationIterator
{

    /**
     * The template provider for error code.
     *
     * @var TemplateProvider
     */
    protected $provider;

    /**
     * The string interpolator to use to format the error.
     *
     * @var StringInterpolator
     */
    protected $interpolator;

    public function __construct($templateProvider)
    {
        $this->provider = $templateProvider;
        $this->interpolator = new StringInterpolator();
    }

    /**
     * Iterate and inject messages interpolated for detected constraint violation.
     *
     * @param Violation $violation
     * @return void
     */
    public function iterate($violation)
    {
        $iterator = new \ArrayIterator([$violation]);
        $iterator->rewind();

        $stack = [];
        $stackLength = 0;
        $notCompleted = true;
        while ($notCompleted)
        {
            if ($iterator->valid())
            {
                // Handle the current violation
                $violation = $iterator->current();
                foreach ($violation->getViolations() as $constraintViolation)
                {
                    // Inject the value in the parameter array
                    $parameters = $constraintViolation->getParameters();
                    $parameters["_value"] = $violation->getValue();
    
                    // Interpolate the string error template
                    $constraintViolation->setMessage(
                        $this->interpolator->interpolate(
                            $this->provider->getTemplate($constraintViolation->getCode()),
                            $parameters,
                        ),
                    );
                }
                // Call next to complete the treatment on the current item
                $iterator->next();

                // When children are available, stack the current iterator and iterate on children
                if ($violation->hasChildren())
                {
                    \array_push($stack, $iterator);
                    ++$stackLength;

                    $iterator = new \ArrayIterator($violation->getChildren());
                    $iterator->rewind();
                }
            }
            else if ($stackLength > 0)
            {
                // There are iterators to pop from the stack
                $iterator = \array_pop($stack);
                --$stackLength;
            }
            else
            {
                // No more iterator valid to handle -> stop the loop
                $notCompleted = false;
            }
        }
    }

}
