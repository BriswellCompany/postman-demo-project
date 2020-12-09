<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\GroupController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// get: api/auth
Route::post('auth', [ AuthController::class, 'auth' ]);

Route::group(['prefix' => 'users', 'middleware' => ['api.authentication']], function() {
    Route::get('', [ UserController::class, 'search' ]);
    Route::post('', [ UserController::class, 'create' ]);
    Route::get('{uid}', [ UserController::class, 'searchUid' ]);
    Route::patch('{uid}', [ UserController::class, 'update' ]);
});

Route::group(['prefix' => 'groups', 'middleware' => ['api.authentication']], function() {
    Route::get('', [ GroupController::class, 'search' ]);
    Route::get('{group_id}', [ GroupController::class, 'searchUid' ]);
    Route::patch('{group_id}', [ GroupController::class, 'update' ]);
});

