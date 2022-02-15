<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['guest:api']], function () {
   Route::get('/', function () {
       return 'ola mundo sem autenticacao';
   });

    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [LoginController::class, 'register']);
});

Route::group(['middleware' => 'auth:api'], function () {
   Route::get('/autenticado', function () {
       return 'ola mundo com autenticacao';
   });
    Route::get('/logout', [LoginController::class, 'logout']);
});
