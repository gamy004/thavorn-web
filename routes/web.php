<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/app', function () {
    return view('app');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'as' => 'api:',
    'prefix' => 'api',
    'namespace' => '\App\Http\Api\Controllers',
    'middleware' => ['api.parse'],
], function () {
    Route::group([
        'as' => 'pawns.',
        'prefix' => 'pawns',
    ], function () {
        Route::post('{pawn}/pay', 'PawnController@pay')->name('pay');
    });

    Route::resources([
        'users' => 'UserController',
        'pawns' => 'PawnController',
        'pawn_items' => 'PawnItemController',
        'pawn_user_items' => 'PawnUserItemController',
        'item_damages' => 'ItemDamageController',
        'item_categories' => 'ItemCategoryController'
    ]);
});
