<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
	protected $table = 'compra'; //Importante: Indica que el nombre de la tabla NO debe ser auto-asignado por Laravel
    
    // ==================== Relaciones ==================== //
    public function proveedor() { return $this->hasMany('App\Models\Proveedor'); } //Relación: "Uno a Muchos"
    public function compraDetalle() { return $this->hasMany('App\Models\CompraDetalle'); } //Relación: "Uno a Muchos"

    // ==================== Buscadores ==================== //
    public function scopeId($query, $id)  //Búsqueda por ID
    {
    	if($id) return $query->where('compra.id', '=', "$id");
    }

   	public function scopeDenominacion($query, $denominacion)  //Búsqueda por coincidencia en la Denominación
    {
    	if($denominacion) return $query->where('compra.denominacion', 'LIKE', "%$denominacion%");
    }
}
