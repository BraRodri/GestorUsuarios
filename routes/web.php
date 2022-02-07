<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

//login
Route::post('/validar-login', [LoginController::class, 'login'])->name('validar_login');

Route::group(['middleware' => 'auth', 'prefix' => '/'], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //usuarios
    Route::controller(UserController::class)
    ->group(function () {
        Route::get('/agregar', 'agregarUsuario')->name('user.agregar');
        Route::get('/ver', 'verUsuario')->name('user.ver');
        Route::get('/obtener-usuarios', 'obtenerUsuarios')->name('user.get');
        Route::post('/registrar-usuario', 'registrarUsuario')->name('user.registrar');
        Route::get('/obtener-usuario/{id}', 'getUsuario')->name('user.getUsuario');
        Route::post('/registrar-usuario/actualizar', 'actualizarUsuario')->name('user.actualizar');
        Route::get('/busqueda-rapida/{parametro}', 'busquedaRapida')->name('user.busquedaRapida');
        Route::get('/eliminar-usuario/{id}', 'eliminarUsuario')->name('user.eliminar');
    });

});
