<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'postsblog';

    protected $fillable = [
        'tipo_post_id',
        'titulo',
        'notica',
        'imagen',
        'fecha_public'
    ];

    public function tipo(){
        return $this->belongsTo(TipoPost::class, 'tipo_post_id');
    }
}
