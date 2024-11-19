<?php

use App\Http\Controllers\autoreController;
use App\Http\Controllers\categoriaController;
use App\Http\Controllers\libroController;
use Illuminate\Support\Facades\Route;
/*
Route::get('/', function () {
    return view('welcome');
});*/

//rutas categorias

Route::resource('categorias',categoriaController::class);


//rutas libros
Route::resource('libros',libroController::class);

//rutas autores
Route::resource('autores',autoreController::class);

Route::get('/', function () {
    return view('template');
});
Route::get('/panel', function () {
    return view('panel.index');
})->name('panel');
Route::get('/login', function () {
    return view('auth.login');
});
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