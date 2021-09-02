<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
	protected $table = 'cliente'; //Importante: Indica que el nombre de la tabla NO debe ser auto-asignado por Laravel

	// ==================== Relaciones ==================== //
	public function venta() { return $this->hasMany('App\Models\Venta'); } //Relación: "Uno a Muchos"

	// ==================== Buscadores ==================== //
	public function scopeId($query, $id)  //Búsqueda por ID
	{
		if($id) return $query->where('cliente.id', '=', "$id");
	}

	public function scopeDenominacion($query, $denominacion)  //Búsqueda por coincidencia en la Denominación
	{
        if($denominacion) return $query->whereRaw('CONCAT(cliente.apellido, " ", cliente.nombre) LIKE "%'.$denominacion.'%"');
	}

	public function scopeEstado($query, $estado)  //Búsqueda por Estado
    {
        if($estado) if ($estado != 'TODOS') return $query->where('cliente.estado', '=', "$estado");
    }
}
