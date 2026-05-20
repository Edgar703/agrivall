<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'categorias';

    // Esta tabla no usa created_at ni updated_at
    public $timestamps = false;

    // Campos que se pueden rellenar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function productos(): HasMany
    {
        // Una categoría tiene muchos productos
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}
