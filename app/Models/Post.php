<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

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
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function tipoPost()
    {
        return $this->belongsTo(TipoPost::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}
