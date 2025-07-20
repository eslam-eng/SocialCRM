<?php

namespace App\Providers;

use App\Helpers\ApiResponse;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        Relation::morphMap([
            'currency' => Currency::class,
            'tag' => Tag::class,
            'customer' => Customer::class,
            'product' => Product::class,
        ]);

        RateLimiter::for('login', function (Request $request) {
            return [
                Limit::perMinute(1000),
                Limit::perMinute(3)->by($request->input('email'))->response(function (Request $request, array $headers) {
                    $retryAfter = $headers['Retry-After'] ?? 60;
                    return ApiResponse::error(message: "Too many attempts. Try again in {$retryAfter} seconds.", code: 429);
                }),
            ];
        });

        RateLimiter::for('throttle_fallback', function (Request $request) {
            return [
                Limit::perMinute(500),
                Limit::perMinute(3)->by($request->input('email'))->response(function (Request $request, array $headers) {
                    $retryAfter = $headers['Retry-After'] ?? 60;
                    return ApiResponse::error(message: "Too many attempts. Try again in {$retryAfter} seconds.", code: 429);
                }),
            ];
        });

        RateLimiter::for('verification_code', function (Request $request) {
            return Limit::perMinute(1)->by($request->input('email'))
                ->response(function (Request $request, array $headers) {
                    $retryAfter = $headers['Retry-After'] ?? 60;
                    return ApiResponse::error(message: "Too many password reset attempts for this email. Try again in {$retryAfter} seconds.", code: 429);
                });
        });
    }
}
