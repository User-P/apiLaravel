<?php

namespace App\Providers;

use App\Product;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::updated(function ($product) {
            if ($product->quantity == 0 && $product->available()) {
                $product->status = Product::NOT_AVAILABLE;
                $product->save();
            }
        });
    }
}
