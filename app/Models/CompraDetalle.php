<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
	protected $table = 'compra_detalle'; //Importante: Indica que el nombre de la tabla NO debe ser auto-asignado por Laravel
    
    // ==================== Relaciones ==================== //
    public function compra() { return $this->belongsTo('App\Models\Compra'); } //Relación Inversa: "Muchos a Uno"
    public function articulo() { return $this->belongsTo('App\Models\Articulo'); } //Relación Inversa: "Muchos a Uno"
   
    // ==================== Buscadores ==================== //
    public function scopeId($query, $id)  //Búsqueda por ID
    {
    	if($id) return $query->where('compra_detalle.id', '=', "$id");
    }

   	public function scopeDenominacion($query, $denominacion)  //Búsqueda por coincidencia en la Denominación
    {
    	if($denominacion) return $query->where('compra_detalle.denominacion', 'LIKE', "%$denominacion%");
    }
}
