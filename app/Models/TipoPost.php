<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPost extends Model
{
    protected $table = 'tipo_post';

    protected $fillable = [
        'tipo'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'tipo_post_id');
    }
}
