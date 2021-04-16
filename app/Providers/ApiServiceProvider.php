<?php

namespace App\Providers;

use App\Http\Api\Parser;
use Illuminate\Support\ServiceProvider;
use App\Http\Api\Contracts\ApiInterface;
use App\Http\Api\Contracts\StoreFormRequestInterface;
use App\Http\Api\Contracts\UpdateFormRequestInterface;
use App\Http\Api\Requests\PawnRequests\StorePawnRequest;
use App\Http\Api\Requests\PawnRequests\UpdatePawnRequest;
use App\Http\Api\Requests\PawnItemRequests\StorePawnItemRequest;
use App\Http\Api\Requests\PawnItemRequests\UpdatePawnItemRequest;

class ApiServiceProvider extends ServiceProvider
{
    const REQUEST_STORE = "store";
    const REQUEST_UPDATE = "update";

    protected $request_interfaces = [
        self::REQUEST_STORE => StoreFormRequestInterface::class,
        self::REQUEST_UPDATE => UpdateFormRequestInterface::class,
    ];

    protected $controllers = [
        \App\Http\Api\Controllers\UserController::class => [
            "api" => \App\Http\Api\Providers\UserApi::class
        ],
        \App\Http\Api\Controllers\PawnItemController::class => [
            "api" => \App\Http\Api\Providers\PawnItemApi::class,
            // "validations" => [
            //     self::REQUEST_STORE => StorePawnItemRequest::class,
            //     self::REQUEST_UPDATE => UpdatePawnItemRequest::class,
            // ]
        ],
        \App\Http\Api\Controllers\PawnUserItemController::class => [
            "api" => \App\Http\Api\Providers\PawnUserItemApi::class
        ],
        \App\Http\Api\Controllers\ItemDamageController::class => [
            "api" => \App\Http\Api\Providers\ItemDamageApi::class
        ],
        \App\Http\Api\Controllers\ItemCategoryController::class => [
            "api" => \App\Http\Api\Providers\ItemCategoryApi::class
        ],
        \App\Http\Api\Controllers\PawnController::class => [
            "api" => \App\Http\Api\Providers\PawnApi::class,
            // "validations" => [
            //     self::REQUEST_STORE => StorePawnRequest::class,
            //     self::REQUEST_UPDATE => UpdatePawnRequest::class,
            // ]
            ],
        \App\Http\Api\Controllers\FileController::class => [
            "api" => \App\Http\Api\Providers\FileApi::class
        ]
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
            if (isset($api['api'])) {
                $this->app->when($controller)
                    ->needs(ApiInterface::class)
                    ->give($api['api']);
            }

            if (isset($api['validations']) && is_array($api['validations'])) {
                foreach ($api['validations'] as $validation_method => $validation_class) {
                    if (array_key_exists($validation_method, $this->request_interfaces)) {
                        $this->app->when($controller)
                            ->needs($this->request_interfaces[$validation_method])
                            ->give($validation_class);
                    }
                }
            }
        }
    }
}
