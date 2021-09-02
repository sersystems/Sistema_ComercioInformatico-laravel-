<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
	protected $table = 'proveedor'; //Importante: Indica que el nombre de la tabla NO debe ser auto-asignado por Laravel

	// ==================== Relaciones ==================== //
	public function compra() { return $this->hasMany('App\Models\Compra'); } //Relación: "Uno a Muchos"

	// ==================== Buscadores ==================== //
	public function scopeId($query, $id)  //Búsqueda por ID
	{
		if($id) return $query->where('proveedor.id', '=', "$id");
	}

	public function scopeDenominacion($query, $denominacion)  //Búsqueda por coincidencia en la Denominación
	{
		if($denominacion) return $query->where('proveedor.denominacion', 'LIKE', "%$denominacion%");
	}

	public function scopeEstado($query, $estado)  //Búsqueda por Estado
    {
        if($estado) if ($estado != 'TODOS') return $query->where('proveedor.estado', '=', "$estado");
    }
}
