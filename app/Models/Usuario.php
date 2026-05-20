<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    // Permite usar factories y notificaciones
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Nombre de la tabla en la base de datos
    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        // Un usuario tiene muchos posts
        return $this->hasMany(Post::class, 'user_id');
    }

    public function comentarios()
    {
        // Un usuario tiene muchos comentarios
        return $this->hasMany(Comentario::class, 'user_id');
    }

    public function reservas()
    {
        // Un usuario tiene muchas reservas
        return $this->hasMany(Reserva::class, 'user_id');
    }

    public function pedidos()
    {
        // Un usuario tiene muchos pedidos
        return $this->hasMany(Pedido::class, 'user_id');
    }
}
