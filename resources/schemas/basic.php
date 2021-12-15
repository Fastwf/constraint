<?php

// Allows to cover the ArrayFactory::addChildSchemaConstraint method

return [
    'type' => 'array',
    'minItems' => 1,
    'items' => [
        'type' => 'integer',
        'nullable' => true,
    ],
];
