<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Post;
use App\Models\Comentario;
use App\Models\TipoPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Limpiar datos existentes (opcional)
        // Comentario::truncate();
        // Post::truncate();
        // Usuario::truncate();

        // Crear un tipo de post por defecto si no existe
        $tipoPost = TipoPost::firstOrCreate(
            ['tipo' => 'Blog'],
            []
        );

        // Crear 3 usuarios
        $usuarios = Usuario::factory(3)->create();

        // Para cada usuario, crear 3 posts con 3 comentarios cada uno
        foreach ($usuarios as $usuario) {
            $posts = Post::factory(3)->create([
                'user_id' => $usuario->id,
                'tipo_post_id' => $tipoPost->id,
            ]);

            foreach ($posts as $post) {
                // Crear 3 comentarios por post, de usuarios aleatorios
                for ($i = 0; $i < 3; $i++) {
                    Comentario::factory()->create([
                        'post_id' => $post->id,
                        'user_id' => $usuarios->random()->id,
                    ]);
                }
            }
        }

        echo "✓ Seeders completado:\n";
        echo "  - 3 Usuarios\n";
        echo "  - 9 Posts (3 por usuario)\n";
        echo "  - 27 Comentarios (3 por post)\n";
    }
}
