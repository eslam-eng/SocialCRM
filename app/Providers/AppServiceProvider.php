<?php

namespace App\Providers;

use App\Models\Currency;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\Relation;
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
            '',
        ]);
    }
}
