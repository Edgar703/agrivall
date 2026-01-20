<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'tipo_post_id',
        'titulo',
        'notica',
        'imagen',
        'fecha_public'
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function tipoPost()
    {
        return $this->belongsTo(TipoPost::class);
    }
}
