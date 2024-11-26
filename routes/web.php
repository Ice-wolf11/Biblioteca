<?php

use App\Http\Controllers\autoreController;
use App\Http\Controllers\categoriaController;
use App\Http\Controllers\libroController;
use App\Http\Controllers\copia_libroController;
use App\Http\Controllers\areaController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\personaController;
use Illuminate\Support\Facades\Route;
/*
Route::get('/', function () {
    return view('welcome');
});*/

//rutas categorias

Route::resource('categorias',categoriaController::class);


//rutas libros
Route::resource('libros',libroController::class);

//rutas copia_Libros
Route::resource('copia_libros',copia_libroController::class);
// routes/web.php

//rutas autores
Route::resource('autores',autoreController::class);

//rutas areas
Route::resource('areas',areaController::class);


//rutas pesonas
Route::resource('personas',personaController::class);

//rutas login

Route::get('/login', [loginController::class,'index'])->name('login');
Route::post('/login', [loginController::class,'login']);
Route::get('/logout',[logoutController::class,'logout'])->name('logout');
//rutas vistas principales
Route::get('/', function () {
    return view('welcome');
})->name('index');
Route::get('/panel',[homeController::class,'index'])->name('panel');



Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
});
Route::get('/401', function () {
    return view('pages.401');
});
Route::get('/404', function () {
    return view('pages.404');
});
Route::get('/500', function () {
    return view('pages.500');
});