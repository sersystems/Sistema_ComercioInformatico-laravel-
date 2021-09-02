<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
	protected $table = 'venta'; //Importante: Indica que el nombre de la tabla NO debe ser auto-asignado por Laravel
    
    // ==================== Relaciones ==================== //
    public function cliente() { return $this->belongsTo('App\Models\Cliente'); } //Relación Inversa: "Muchos a Uno"
    public function ventaDetalle() { return $this->hasMany('App\Models\VentaDetalle'); } //Relación: "Uno a Muchos"
    
    // ==================== Buscadores ==================== //
    public function scopeId($query, $id)  //Búsqueda por ID
    {
    	if($id) return $query->where('venta.id', '=', "$id");
    }

   	public function scopeCuitCliente($query, $cuitCliente)  //Búsqueda por coincidencia en el CUIT/CUIL del Cliente
    {
    	if($cuitCliente) return $query->where('cliente.cuit', '=', "$cuitCliente");
    }

    public function scopeDenominacionCliente($query, $denominacionCliente)  //Búsqueda por coincidencia en la Denominación del Cliente
    {
        if($denominacionCliente) return $query->whereRaw('CONCAT(cliente.apellido, " ", cliente.nombre) LIKE "%'.$denominacionCliente.'%"');
    }

    public function scopeEstado($query, $estado)  //Búsqueda por Estado
    {
        if($estado) if ($estado != 'TODOS') return $query->where('venta.estado', '=', "$estado");
    }
}