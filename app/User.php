<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'tipo_usuario','denominacion', 'email', 'password',
    ];

    protected $hidden = [
         'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ==================== Buscadores ==================== //
	public function scopeId($query, $id)  //Búsqueda por ID
	{
		if($id) return $query->where('users.id', '=', "$id");
	}

	public function scopeDenominacion($query, $denominacion)  //Búsqueda por coincidencia en la Denominación
	{
		if($denominacion) return $query->where('users.denominacion', 'LIKE', "%$denominacion%");
	}
}
