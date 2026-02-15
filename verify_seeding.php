<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Verificar datos creados
$usuariosCount = \App\Models\Usuario::count();
$postsCount = \App\Models\Post::count();
$comentariosCount = \App\Models\Comentario::count();

echo "✓ Usuarios creados: " . $usuariosCount . "\n";
echo "✓ Posts creados: " . $postsCount . "\n";
echo "✓ Comentarios creados: " . $comentariosCount . "\n";

// Mostrar detalles de estructura
echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "DETALLES DE LA ESTRUCTURA\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

$usuarios = \App\Models\Usuario::with('posts')->get();

foreach ($usuarios as $index => $usuario) {
    $num = $index + 1;
    echo $num . ". Usuario: {$usuario->name}\n";
    echo "   Email: {$usuario->email}\n";
    echo "   Posts: {$usuario->posts->count()}\n";
    
    foreach ($usuario->posts as $posIndex => $post) {
        $comentarios = \App\Models\Comentario::where('post_id', $post->id)->get();
        $posNum = $posIndex + 1;
        echo "   └─ Post " . $posNum . ": {$post->titulo}\n";
        echo "      Comentarios: {$comentarios->count()}\n";
    }
    echo "\n";
}
