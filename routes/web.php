<?php

use Illuminate\Support\Facades\Route;

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

//Ambos funcionan OK: Route::resource (sirve para todos los casos HTTP) y Route::get
Route::resource('/', 'App\Http\Controllers\ClientesController');
//Route::get('/', 'App\Http\Controllers\ClientesController@index');
Route::resource('/registro', 'App\Http\Controllers\ClientesController'); //10. recibiendo datos del cliente API
Route::resource('/curso', 'App\Http\Controllers\CursoController'); //14. Creando el Modelo y Controlador de la tabla Cursos
