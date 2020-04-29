<?php

namespace App\Providers;

use App\User;
use App\Buyer;
use App\Seller;
use Carbon\Carbon;
use App\Policies\UserPolicy;
use App\Policies\BuyerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\SellerPolicy;
use App\Policies\TransactionPolicy;
use App\Product;
use App\Transaction;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Buyer::class => BuyerPolicy::class,
        Seller::class => SellerPolicy::class,
        User::class => UserPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('admin-action', function ($user) {
            return $user->administrator();
        });

        Passport::routes();

        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();

        Passport::tokensCan([
            'purchase-product' => 'Crear transacciones para comprar productos determinados',
            'manage-products' => 'Crear,ver, actualizar y eliminar productos',
            'manage-account' => 'Optener la informacion de la cuenta, nombre, email, estado, modificar datos como email, nombre y contraseña, NO se puede eliminar la cuenta',
            'read-general' => 'OPtener informacion general, categorias donde se compra y se vende, productos vendidos o comprads, transacciones, compras y ventas'
        ]);
    }
}
