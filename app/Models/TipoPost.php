<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPost extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'tipo_post';

    // Campos que se pueden rellenar masivamente
    protected $fillable = [
        'tipo'
    ];

    public function posts()
    {
        // Un tipo de post tiene muchos posts
        return $this->hasMany(Post::class, 'tipo_post_id');
    }
}
