<?php

use App\Http\Controllers\autoreController;
use App\Http\Controllers\categoriaController;
use App\Http\Controllers\catalogoController;
use App\Http\Controllers\libroController;
use App\Http\Controllers\copia_libroController;
use App\Http\Controllers\areaController;
use App\Http\Controllers\devolucioneController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\personaController;
use App\Http\Controllers\prestamoController;
use App\Http\Controllers\reservaController;
use Illuminate\Support\Facades\Route;



//rutas devoluciones
Route::resource('devoluciones', devolucioneController::class);

//rutas penalizacion

//ruta para reservas
Route::resource('reservas', reservaController::class)->except(['create']);

Route::get('reserva/create/{id}', [reservaController::class, 'create'])->name('reservas.create');

//rutas prestamos
Route::resource('prestamos',prestamoController::class);
Route::get('prestamo/create-catalogo/{id}', [prestamoController::class, 'create_catalogo'])->name('prestamos.create-catalogo');
Route::get('prestamo/create-reserva/{id}', [prestamoController::class, 'create_reserva'])->name('prestamos.create-reserva');
Route::post('prestamos/store-catalogo', [prestamoController::class, 'store_catalogo'])->name('prestamos.store_catalogo');
Route::post('prestamos/store-reserva', [prestamoController::class, 'store_reserva'])->name('prestamos.store_reserva');


//ruta catalogo
//Route::get('/catalogo', [catalogoController::class, 'index'])->name('catalogo.index');
Route::get('/catalogo/filter', [catalogoController::class, 'filter'])->name('catalogo.filter');
Route::resource('catalogo', catalogoController::class);

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
Route::get('persona/search', [personaController::class, 'search'])->name('persona.search');


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