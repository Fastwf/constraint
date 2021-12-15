<?php

// Use the "$ref" => "date.php" multiple times to use the cached schema
// Add "required" constraint to force ObjectFactory to cover required properties code section 

return [
    "type" => "object",
    "properties" => [
        "start" => [
            '$ref' => 'start-date.php',
        ],
        "end" => [
            '$ref' => 'primary@date.php',
        ],
    ],
    'required' => [
        'start',
        'end',
    ],
];
