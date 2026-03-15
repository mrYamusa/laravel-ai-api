<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $fallbackAppUrl = 'https://laravel-gemini-app-219d31ff1cec.herokuapp.com';
        $legacyHost = 'laravel-gemini-app.herokuapp.com';
        $currentHost = 'laravel-gemini-app-219d31ff1cec.herokuapp.com';
        $configuredAppUrl = (string) config('app.url');
        $appUrl = $configuredAppUrl;

        if (! $appUrl) {
            $appUrl = $fallbackAppUrl;
        } elseif (str_starts_with($appUrl, 'http://laravel-gemini-app-219d31ff1cec.herokuapp.com')) {
            $appUrl = preg_replace('/^http:/', 'https:', $appUrl);
        }

        $appUrl = str_replace('://'.$legacyHost, '://'.$currentHost, $appUrl);

        $appUrl = rtrim($appUrl, '/');
        URL::forceRootUrl($appUrl);

        if (config('app.env') === 'production' || (bool) env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(30)->by($request->user()?->id ?: $request->ip());
        });

        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            // Custom logic after OpenAPI is generated
            $openApi->info->title = 'Gemini Image to JSON Prompt Generation API';
            $openApi->info->description = 'REST API for image-to-json-prompt generation, auth-protected endpoints, and prompt history.';
            $openApi->secure(SecurityScheme::http('bearer', 'BearerAuth'));
        });
    }
}
