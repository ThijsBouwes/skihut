<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Horizon\Horizon;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Register only the routes we use
        $callback = function ($router) {
            $router->forAccessTokens();
        };

        Passport::routes($callback, ['prefix' => 'api/oauth', 'middleware' => ['json', 'injectSecret']]);

        Passport::tokensExpireIn(Carbon::now()->addDays(5));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
    }
}
