<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
	protected $table = 'mensaje'; //Importante: Indica que el nombre de la tabla NO debe ser auto-asignado por Laravel
    
    // ==================== Buscadores ==================== //
    public function scopeId($query, $id)  //Búsqueda por ID
    {
    	if($id) return $query->where('mensaje.id', '=', "$id");
    }

   	public function scopeDenominacion($query, $denominacion)  //Búsqueda por coincidencia en la Denominación
    {
    	if($denominacion) return $query->where('mensaje.denominacion', 'LIKE', "%$denominacion%");
    }

    public function scopeEstado($query, $estado)  //Búsqueda por Estado
    {
        if($estado) if ($estado != 'TODOS') return $query->where('mensaje.estado', '=', "$estado");
    }
}
