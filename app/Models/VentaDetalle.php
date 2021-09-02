<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
	protected $table = 'venta_detalle'; //Importante: Indica que el nombre de la tabla NO debe ser auto-asignado por Laravel
    
    // ==================== Relaciones ==================== //
    public function venta() { return $this->belongsTo('App\Models\Venta'); } //Relación Inversa: "Muchos a Uno"
    public function articulo() { return $this->belongsTo('App\Models\Articulo'); } //Relación Inversa: "Muchos a Uno"
   
    // ==================== Buscadores ==================== //
   	public function scopeIdVenta($query, $idVenta)  //Búsqueda por coincidencia en la Denominación
    {
    	if($idVenta) return $query->where('venta_detalle.venta_id', '=', "$idVenta");
    }
}