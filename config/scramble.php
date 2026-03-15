<?php

$appUrl = rtrim((string) env('APP_URL', 'http://localhost:8000'), '/');
$scrambleApiServer = env('SCRAMBLE_API_SERVER', $appUrl.'/api');

return [
    'middleware' => ['web'],

    'servers' => [
        'API' => $scrambleApiServer,
    ],

    'info' => [
        'version' => env('API_VERSION', '1.0.0'),
        'description' => 'REST API for image-to-json-prompt generation, auth-protected endpoints, and prompt history.',
    ],

    'ui' => [
        'title' => 'Yamusa Laravel Gemini API Docs',
    ],
];
