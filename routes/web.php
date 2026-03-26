<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\AdminUsuarioController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\AdminPedidoController;
use Illuminate\Support\Facades\Route;

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

// Catálogo público de productos
Route::get('/catalogo', [ProductoController::class, 'catalogo'])->name('productos.catalogo');

// ============================================================================
// BLOG POSTS
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

// ============================================================================
// USUARIOS LOGEADOS
// ============================================================================
Route::middleware('auth')->group(function () {
    Route::resource('reservas', ReservaController::class);
    Route::patch('/reservas/{reserva}/estado', [ReservaController::class, 'cambiarEstado'])->name('reservas.cambiarEstado');

    // ================================================================
    // CARRITO
    // ================================================================
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/add', [CarritoController::class, 'add'])->name('carrito.add');
    Route::patch('/carrito/update', [CarritoController::class, 'update'])->name('carrito.update');
    Route::delete('/carrito/remove/{productoId}', [CarritoController::class, 'remove'])->name('carrito.remove');
    Route::delete('/carrito/clear', [CarritoController::class, 'clear'])->name('carrito.clear');

    // ================================================================
    // PEDIDOS (usuario)
    // ================================================================
    Route::get('/checkout', [PedidoController::class, 'checkout'])->name('pedidos.checkout');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/mis-pedidos', [PedidoController::class, 'misPedidos'])->name('pedidos.misPedidos');
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::delete('/pedidos/{pedido}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');

    // ============================================================================
    // RESERVAS DE CASA RURAL
    // ============================================================================
    Route::prefix('admin')->name('admin.')->group(function () {
        // Admin panel - same controller, filtra por rol
        Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');

        // Gestión de usuarios
        Route::get('/usuarios', [AdminUsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/{usuario}', [AdminUsuarioController::class, 'show'])->name('usuarios.show');
        Route::get('/usuarios/{usuario}/edit', [AdminUsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::patch('/usuarios/{usuario}', [AdminUsuarioController::class, 'update'])->name('usuarios.update');

        // Gestión de pedidos
        Route::get('/pedidos', [AdminPedidoController::class, 'index'])->name('pedidos.index');
        Route::get('/pedidos/{pedido}', [AdminPedidoController::class, 'show'])->name('pedidos.show');
        Route::patch('/pedidos/{pedido}/estado', [AdminPedidoController::class, 'cambiarEstado'])->name('pedidos.cambiarEstado');
        Route::delete('/pedidos/{pedido}', [AdminPedidoController::class, 'destroy'])->name('pedidos.destroy');

        // Gestión de productos
        Route::resource('productos', ProductoController::class);
        Route::post('/categorias', [ProductoController::class, 'storeCategoria'])->name('categorias.store');
        Route::delete('/categorias/{categoria}', [ProductoController::class, 'destroyCategoria'])->name('categorias.destroy');
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
