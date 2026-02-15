<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';

    protected $fillable = [
        'post_id',
        'user_id',
        'contenido',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }
}
