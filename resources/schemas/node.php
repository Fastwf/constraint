<?php

// Allows to cover the ObjectFactory 'additionalProperties' and 'properties' sections

return [
    'type' => 'object',
    'properties' => [
        'parent' => [
            '$ref' => 'node.php',
        ],
        'value' => [
            'nullable' => true,
        ]
    ],
    'additionalProperties' => [
        '$ref' => 'node.php',
    ],
    'nullable' => true,
];
