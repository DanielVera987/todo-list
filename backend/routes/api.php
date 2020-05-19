<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiAuthMiddleware;

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
Route::post('registro', 'UserController@register');
Route::post('login', 'UserController@login');

//Rutas para el usuario
Route::put('user/update', 'UserController@update');

//Routes for task
Route::resource('task','TaskController');

//Routes for etiquet
Route::resource('etiqueta', 'EtiquetaController');
