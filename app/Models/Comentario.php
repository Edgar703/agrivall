<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    // Permite usar factories para pruebas o seeders
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'comentarios';

    // Campos que se pueden rellenar masivamente
    protected $fillable = [
        'post_id',
        'user_id',
        'contenido',
    ];

    public function post()
    {
        // Un comentario pertenece a un post
        return $this->belongsTo(Post::class);
    }

    public function usuario()
    {
        // Un comentario pertenece a un usuario
        return $this->belongsTo(Usuario::class, 'user_id');
    }
}
