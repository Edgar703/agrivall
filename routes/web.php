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
use App\Models\Reserva;
use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', function () {
    return view('index');
})->name('index');

// Perfil del usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Productos públicos
Route::get('/catalogo', [ProductoController::class, 'catalogo'])->name('productos.catalogo');
Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');

// Posts del blog
Route::get('/posts/index2', [PostController::class, 'index2'])->name('posts.index2');
Route::resource('posts', PostController::class)->only(['index', 'show']);
Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)->except(['index', 'show']);
});

// Comentarios de posts
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');
Route::delete('/comments/{comentario}', [CommentController::class, 'destroy'])->middleware('auth')->name('comments.destroy');

// API de reservas
Route::get('/api/reservas/fechas-bloqueadas', [ReservaController::class, 'fechasBloqueadas'])->name('api.reservas.fechas-bloqueadas');
Route::post('/api/reservas/calcular-precio', [ReservaController::class, 'calcularPrecioApi'])->name('api.reservas.calcular-precio');

// Rutas para usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::resource('reservas', ReservaController::class);
    Route::patch('/reservas/{reserva}/estado', [ReservaController::class, 'cambiarEstado'])->name('reservas.cambiarEstado');

    // Carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/add', [CarritoController::class, 'add'])->name('carrito.add');
    Route::patch('/carrito/update', [CarritoController::class, 'update'])->name('carrito.update');
    Route::delete('/carrito/remove/{itemKey}', [CarritoController::class, 'remove'])->name('carrito.remove');
    Route::delete('/carrito/clear', [CarritoController::class, 'clear'])->name('carrito.clear');

    // Pedidos del usuario
    Route::get('/checkout', [PedidoController::class, 'checkout'])->name('pedidos.checkout');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/mis-pedidos', [PedidoController::class, 'misPedidos'])->name('pedidos.misPedidos');
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::delete('/pedidos/{pedido}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');

    // Panel de administración
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Reservas del admin
        Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');

        // Usuarios
        Route::get('/usuarios', [AdminUsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/{usuario}', [AdminUsuarioController::class, 'show'])->name('usuarios.show');
        Route::get('/usuarios/{usuario}/edit', [AdminUsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::patch('/usuarios/{usuario}', [AdminUsuarioController::class, 'update'])->name('usuarios.update');

        // Pedidos
        Route::get('/pedidos', [AdminPedidoController::class, 'index'])->name('pedidos.index');
        Route::get('/pedidos/{pedido}', [AdminPedidoController::class, 'show'])->name('pedidos.show');
        Route::patch('/pedidos/{pedido}/estado', [AdminPedidoController::class, 'cambiarEstado'])->name('pedidos.cambiarEstado');
        Route::delete('/pedidos/{pedido}', [AdminPedidoController::class, 'destroy'])->name('pedidos.destroy');

        // Productos y categorías
        Route::resource('productos', ProductoController::class);
        Route::post('/categorias', [ProductoController::class, 'storeCategoria'])->name('categorias.store');
        Route::patch('/categorias/{categoria}', [ProductoController::class, 'updateCategoria'])->name('categorias.update');
        Route::delete('/categorias/{categoria}', [ProductoController::class, 'destroyCategoria'])->name('categorias.destroy');
    });
});

// Páginas estáticas
Route::get('/casa-rural', function () {
    // Obtener reservas activas para el calendario
    $reservasActivas = Reserva::whereIn('estado', ['PRE-RESERVA', 'RESERVADO', 'NO_DISPONIBLE'])
        ->where('fecha_fin', '>=', now())
        ->orderBy('fecha_inicio')
        ->get(['id', 'fecha_inicio', 'fecha_fin', 'estado']);

    return view('casa-rural.index', compact('reservasActivas'));
})->name('casa-rural');

Route::get('/contactar', [\App\Http\Controllers\ContactoController::class, 'mostrar'])->name('contactar');
Route::post('/contactar', [\App\Http\Controllers\ContactoController::class, 'enviar'])->name('contactar.enviar');

// Rutas de autenticación
require __DIR__ . '/auth.php';
