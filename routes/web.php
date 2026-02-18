<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\AdminUsuarioController;
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
Route::middleware('auth')->group(function () {
    Route::post('/categorias', [ProductoController::class, 'storeCategoria'])->name('categorias.store');
    Route::delete('/categorias/{categoria}', [ProductoController::class, 'destroyCategoria'])->name('categorias.destroy');
});

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
// RESERVAS DE CASA RURAL
// ============================================================================

// API pública para el widget de reservas
Route::get('/api/reservas/fechas-bloqueadas', [ReservaController::class, 'fechasBloqueadas'])->name('api.reservas.fechas-bloqueadas');
Route::post('/api/reservas/calcular-precio', [ReservaController::class, 'calcularPrecioApi'])->name('api.reservas.calcular-precio');

Route::middleware('auth')->group(function () {
    Route::resource('reservas', ReservaController::class);
    Route::patch('/reservas/{reserva}/estado', [ReservaController::class, 'cambiarEstado'])->name('reservas.cambiarEstado');

    Route::prefix('admin')->name('admin.')->group(function () {
        // Admin panel - same controller, filtra por rol
        Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');

        // Gestión de usuarios
        Route::get('/usuarios', [AdminUsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/{usuario}', [AdminUsuarioController::class, 'show'])->name('usuarios.show');
        Route::get('/usuarios/{usuario}/edit', [AdminUsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::patch('/usuarios/{usuario}', [AdminUsuarioController::class, 'update'])->name('usuarios.update');
    });
});

// ============================================================================
// PÁGINAS ESTÁTICAS
// ============================================================================

Route::get('/casa-rural', function () {
    return view('casa-rural.index');
})->name('casa-rural');

Route::get('/contactar', [\App\Http\Controllers\ContactoController::class, 'mostrar'])->name('contactar');
Route::post('/contactar', [\App\Http\Controllers\ContactoController::class, 'enviar'])->name('contactar.enviar');

// ============================================================================
// AUTENTICACIÓN
// ============================================================================

require __DIR__ . '/auth.php';
