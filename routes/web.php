<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('productos', ProductoController::class);
Route::get('/catalogo',[ProductoController::class, 'catalogo'])->name('productos.catalogo');

Route::resource('posts', PostController::class);
Route::get('/casa-rural', function () {
    return view('casa-rural');
})->name('casa-rural');
Route::get('/posts/index2', [PostController::class, 'index2'])->name('posts.index2');

require __DIR__.'/auth.php';
