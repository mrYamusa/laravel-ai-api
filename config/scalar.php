<?php

$fallbackAppUrl = 'https://laravel-gemini-app-219d31ff1cec.herokuapp.com';
$legacyHost = 'laravel-gemini-app.herokuapp.com';
$currentHost = 'laravel-gemini-app-219d31ff1cec.herokuapp.com';
$rawAppUrl = env('APP_URL');

if (! $rawAppUrl) {
    $appUrl = $fallbackAppUrl;
} elseif (str_starts_with($rawAppUrl, 'http://laravel-gemini-app-219d31ff1cec.herokuapp.com')) {
    $appUrl = preg_replace('/^http:/', 'https:', $rawAppUrl);
} else {
    $appUrl = $rawAppUrl;
}

$appUrl = str_replace('://'.$legacyHost, '://'.$currentHost, $appUrl);

$appUrl = rtrim($appUrl, '/');

$scalarOpenApiUrl = env('SCALAR_OPENAPI_URL', $appUrl.'/docs/api.json');
$scalarApiServer = env('SCALAR_API_SERVER', $appUrl.'/api');

$scalarOpenApiUrl = str_replace('://'.$legacyHost, '://'.$currentHost, $scalarOpenApiUrl);
$scalarApiServer = str_replace('://'.$legacyHost, '://'.$currentHost, $scalarApiServer);

return [

    /*
    |--------------------------------------------------------------------------
    | Scalar Domain
    |--------------------------------------------------------------------------
    |
    | This is the subdomain where Scalar will be accessible from. If this
    | setting is null, Scalar will reside under the same domain as the
    | application. Otherwise, this value will serve as the subdomain.
    |
    */
    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Scalar Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Scalar will be accessible from. Feel free
    | to change this path to anything you like. Note that the URI will not
    | affect the paths of its internal API that aren't exposed to users.
    |
    */
    'path' => '/scalar',

    /*
    |--------------------------------------------------------------------------
    | Scalar Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will get attached onto each Scalar route, giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with this list.
    |
    */
    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Scalar OpenAPI Document URL
    |--------------------------------------------------------------------------
    |
    | This is the URL to the OpenAPI document that Scalar will use to generate
    | the API reference. By default, it points to the latest version of the
    | Scalar Galaxy package. You can change this to use a custom OpenAPI file.
    |
    */
    // 'url' => 'https://cdn.jsdelivr.net/npm/@scalar/galaxy/dist/latest.json',
    'url' => $scalarOpenApiUrl,

    /*
    |--------------------------------------------------------------------------
    | Scalar CDN URL
    |--------------------------------------------------------------------------
    |
    | This is the URL to the CDN where Scalar's API reference assets are hosted.
    | By default, it points to the jsDelivr CDN for the @scalar/api-reference
    | package. You can change this if you want to use a different CDN.
    |
    */
    'cdn' => env('SCALAR_CDN_URL', 'https://cdn.jsdelivr.net/npm/@scalar/api-reference@1.48.7'),

    /*
    |--------------------------------------------------------------------------
    | Scalar Configuration
    |--------------------------------------------------------------------------
    |
    | The configuration options for the Scalar API reference. This array
    | contains all the settings that control the behavior and appearance
    | of the API documentation.
    |
    */
    'configuration' => [
        /** A string to use one of the color presets */
        'theme' =>
        // 'alternate',
        // 'bluePlanet',
        'deepSpace',
        // 'default',
        // 'kepler',
        // 'laravel',
        // 'mars',
        // 'moon',
        // 'purple',
        // 'saturn',
        // 'solarized',
        // 'none',

        /** The layout to use for the references */
        'layout' => 'modern',

        /** URL to a request proxy for the API client */
        'proxyUrl' => null,

        /** Whether to show the sidebar */
        'showSidebar' => true,

        /**
         * Whether to show models in the sidebar, search, and content.
         */
        'hideModels' => false,

        /**
         * Whether to show the “Download OpenAPI Document” button
         */
        'hideDownloadButton' => false,

        /**
         * Whether to show the “Test Request” button
         */
        'hideTestRequestButton' => false,

        /**
         * Whether to show the sidebar search bar
         */
        'hideSearch' => false,

        /** Whether dark mode is on or off initially (light mode) */
        'darkMode' => false,

        /** forceDarkModeState makes it always this state no matter what*/
        'forceDarkModeState' => 'dark',

        /** Whether to show the dark mode toggle */
        'hideDarkModeToggle' => false,

        /** Key used with CTRL/CMD to open the search modal (defaults to 'k' e.g. CMD+k) */
        'searchHotKey' => 'k',

        /**
         * If used, passed data will be added to the HTML header
         *
         * @see https://unhead.unjs.io/usage/composables/use-seo-meta
         */
        'metaData' => [
            'title' => 'Gemini Image to JSON Prompt Generation API',
            'description' => 'Upload an image and get a structured AI prompt (JSON) generated with Gemini.',
            'keywords' => 'Laravel, API, Gemini, Image Prompt, AI, OpenAPI',
            'author' => 'mr.yamusa',
        ],

        /**
         * Path to a favicon image
         *
         * @example '/favicon.svg'
         */
        'favicon' => '',

        /**
         * List of httpsnippet clients to hide from the clients menu
         * By default hides Unirest, pass `[]` to show all clients
         */
        'hiddenClients' => [

        ],

        /** Determine the HTTP client that’s selected by default */
        'defaultHttpClient' => [
            'targetId' => 'shell',
            'clientKey' => 'curl',
        ],

        /** Custom CSS to be added to the page */
        // 'customCss' => '',

        /** Prefill authentication */
        // 'authentication' => [
        //     // TODO
        // ],

        /**
         * The baseServerURL is used when the spec servers are relative paths and we are using SSR.
         * On the client we can grab the window.location.origin but on the server we need
         * to use this prop.
         */
        'baseServerURL' => $appUrl,

        /**
         * List of servers to override the openapi spec servers
         */
        'servers' => [
            [
                'url' => $scalarApiServer,
                'description' => 'API server',
            ],
        ],

        /**
         * We’re using Inter and JetBrains Mono as the default fonts. If you want to use your own fonts, set this to false.
         */
        'withDefaultFonts' => true,

        /**
         * By default we only open the relevant tag based on the url, however if you want all the tags open by default then set this configuration option :)
         */
        'defaultOpenAllTags' => false,
    ],

];
