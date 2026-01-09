<?php

use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/catalogo', [ProductoController::class, 'catalogo'])
    ->name('productos.catalogo');

Route::resource('productos', ProductoController::class);