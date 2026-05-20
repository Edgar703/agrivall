<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    // Permite usar factories para pruebas o seeders
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'posts';

    // Campos que se pueden rellenar masivamente
    protected $fillable = [
        'user_id',
        'tipo_post_id',
        'titulo',
        'contenido',
        'imagen',
        'categoria',
        'fecha_public'
    ];

    public function usuario(){
        // Un post pertenece a un usuario
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function tipoPost()
    {
        // Un post pertenece a un tipo de post
        return $this->belongsTo(TipoPost::class);
    }

    public function comentarios()
    {
        // Un post tiene muchos comentarios
        return $this->hasMany(Comentario::class);
    }
}
