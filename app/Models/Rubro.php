<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
	protected $table = 'rubro'; //Importante: Indica que el nombre de la tabla NO debe ser auto-asignado por Laravel
    
    // ==================== Relaciones ==================== //
    public function articulo() { return $this->hasMany('App\Models\Articulo'); } //Relación: "Uno a Muchos"
    
    // ==================== Buscadores ==================== //
    public function scopeId($query, $id)  //Búsqueda por ID
    {
    	if($id) return $query->where('rubro.id', '=', "$id");
    }

   	public function scopeDenominacion($query, $denominacion)  //Búsqueda por coincidencia en la Denominación
    {
    	if($denominacion) return $query->where('rubro.denominacion', 'LIKE', "%$denominacion%");
    }
}
