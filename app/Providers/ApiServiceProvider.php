<?php

namespace App\Providers;

use App\Http\Api\Parser;
use App\Http\Api\Contracts\ApiInterface;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    protected $controllers = [
        \App\Http\Api\Controllers\UserController::class => \App\Http\Api\Providers\UserApi::class
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Parser::class);
        
        foreach ($this->controllers as $controller => $api) {
            $this->app->when($controller)
                ->needs(ApiInterface::class)
                ->give($api);
        }
    }
}
