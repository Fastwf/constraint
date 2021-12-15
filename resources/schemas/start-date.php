<?php

// Extends schema system, that allows to cover LAFactory::createSubConstraints method

return [
    'allOf' => [
        ['$ref' => 'primary@date.php'],
        [
            "type" => "object",
            "properties" => [
                "name" => [
                    "type" => "string",
                    "format" => "not-blank",
                ],
            ],
        ],
    ],
];
