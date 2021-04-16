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
Route::get('/', function () {
    return view('app');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

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
        Route::get('/generate-number', 'PawnController@generateNumber')->name('generate-number');
        Route::post('{pawn}/pay', 'PawnController@pay')->name('pay');
        Route::post('{pawn}/close', 'PawnController@close')->name('close');
        Route::get('{pawn}/paid-amount', 'PawnController@getPaidAmount')->name('paid-amount');
        Route::get('{pawn}/close-amount', 'PawnController@getCloseAmount')->name('close-amount');
    });

    Route::group([
        'as' => 'files.',
        'prefix' => 'files',
    ], function () {
        Route::post('/upload/{user}/evidences', 'FileController@uploadEvidence')->name('upload-evidence');
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

Route::get('/{vue_capture?}', function () {
        return view('app');
    })
    ->where('vue_capture', '[\/\w\.-]*')
    ->name('magicRoute');