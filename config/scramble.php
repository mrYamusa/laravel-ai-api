<?php

$fallbackApiServer = 'https://laravel-gemini-app-219d31ff1cec.herokuapp.com/api';
$legacyHost = 'laravel-gemini-app.herokuapp.com';
$currentHost = 'laravel-gemini-app-219d31ff1cec.herokuapp.com';
$configuredAppUrl = env('APP_URL');

if (! $configuredAppUrl) {
    $defaultApiServer = $fallbackApiServer;
} elseif (str_starts_with($configuredAppUrl, 'http://laravel-gemini-app-219d31ff1cec.herokuapp.com')) {
    $defaultApiServer = preg_replace('/^http:/', 'https:', rtrim($configuredAppUrl, '/')).'/api';
} else {
    $defaultApiServer = rtrim($configuredAppUrl, '/').'/api';
}

$defaultApiServer = str_replace('://'.$legacyHost, '://'.$currentHost, $defaultApiServer);

$scrambleApiServer = env('SCRAMBLE_API_SERVER', $defaultApiServer);
$scrambleApiServer = str_replace('://'.$legacyHost, '://'.$currentHost, $scrambleApiServer);

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
