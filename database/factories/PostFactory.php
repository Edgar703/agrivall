f<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Usuario;
use App\Models\TipoPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo_post_id' => TipoPost::inRandomOrder()->first()?->id ?? TipoPost::factory(),
            'titulo' => $this->faker->sentence(),
            'noticia' => $this->faker->paragraphs(3, true),
            'imagen' => $this->faker->imageUrl(),
            'fecha_public' => $this->faker->dateTime(),
        ];
    }
}
