<?php

use App\Models\VentaDetalle;
use Illuminate\Database\Seeder;

class VentaDetalleTableSeeder extends Seeder
{
    public function run()
    {
        VentaDetalle::create([
        	'venta_id' => '1',
        	'articulo_id' => '1',
        	'denominacion' => 'XXX DEN',
        	'garantia' => '72hs',
        	'cantidad' => '10',
        	'ar_precio' => '10.00',
        	'iva_alicuota' => '21.0',
        	'ar_base' => '2.10',
        	'ar_importe' => '12.10',
        	'ar_costo' => '6.05'
        ]);
    }
}