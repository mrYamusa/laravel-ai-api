<?php

return [
    'middleware' => ['web'],

    'info' => [
        'version' => env('API_VERSION', '1.0.0'),
        'description' => 'REST API for image-to-json-prompt generation, auth-protected endpoints, and prompt history.',
    ],

    'ui' => [
        'title' => 'Yamusa Laravel Gemini API Docs',
    ],
];