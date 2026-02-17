<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Web de Agrivall
|--------------------------------------------------------------------------
*/

// ============================================================================
// PÁGINA PRINCIPAL
// ============================================================================

Route::get('/', function () {
    return view('index');
})->name('index');

// ============================================================================
// PERFIL DE USUARIO
// ============================================================================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================================================
// PRODUCTOS
// ============================================================================

Route::resource('productos', ProductoController::class);
Route::get('/catalogo', [ProductoController::class, 'catalogo'])->name('productos.catalogo');

// ============================================================================
// POSTS
// ============================================================================

Route::resource('posts', PostController::class);
Route::get('/posts/index2', [PostController::class, 'index2'])->name('posts.index2');

// ============================================================================
// COMENTARIOS
// ============================================================================

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');
Route::delete('/comments/{comentario}', [CommentController::class, 'destroy'])->middleware('auth')->name('comments.destroy');

// ============================================================================
// PÁGINAS ESTÁTICAS
// ============================================================================

Route::get('/casa-rural', function () {
    return view('casa-rural.index');
})->name('casa-rural');

Route::get('/contactar', function () {
    return view('contactar');
})->name('contactar');

// ============================================================================
// AUTENTICACIÓN
// ============================================================================

require __DIR__.'/auth.php';
