<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
	protected $table = 'articulo'; //Importante: Indica que el nombre de la tabla NO debe ser auto-asignado por Laravel

    // ==================== Relaciones ==================== //
    public function rubro() { return $this->belongsTo('App\Models\Rubro'); } //Relación Inversa: "Muchos a Uno"
    public function compraDetalle() { return $this->hasMany('App\Models\CompraDetalle'); } //Relación: "Uno a Muchos"
    public function ventaDetalle() { return $this->hasMany('App\Models\VentaDetalle'); } //Relación: "Uno a Muchos"

    // ==================== Buscadores ==================== //
    public function scopeId($query, $id)  //Búsqueda por ID
    {
    	if($id) return $query->where('articulo.id', '=', "$id");
    }

   	public function scopeDenominacion($query, $denominacion)  //Búsqueda por coincidencia en la Denominación
    {
        if($denominacion) return $query->whereRaw('CONCAT(articulo.tipo, " ", articulo.marca, " ", articulo.modelo) LIKE "%'.$denominacion.'%"');
    }

    public function scopeDenominacionRubro($query, $denominacionRubro)  //Búsqueda por Denominación de Rubro
    {
        if($denominacionRubro) return $query->where('rubro.denominacion', '=', "$denominacionRubro");
    }

    public function scopeStock($query, $stock)  //Búsqueda por cantidad de Stock
    {
        if($stock) return $query->where('articulo.stock', '>=', "$stock");
    }

    public function scopeEstado($query, $estado)  //Búsqueda por Estado
    {
        if($estado) if ($estado != 'TODOS') return $query->where('articulo.estado', '=', "$estado");
    }
}