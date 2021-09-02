<?php

use App\Models\CompraDetalle;
use Illuminate\Database\Seeder;

class CompraDetalleTableSeeder extends Seeder
{
    public function run()
    {
        CompraDetalle::create([
        	'compra_id' => '1',
        	'articulo_id' => '1',
        	'denominacion' => 'XXX DEN',
        	'garantia' => '72hs',
        	'cantidad' => '10',
        	'usd_costo_bruto' => '10.000',
        	'iva_alicuota' => '21.0',
        	'usd_iva_base' => '2.100',
        	'usd_costo_neto' => '12.100',
        	'utilidad' => '50.00',
        	'usd_margen' => '6.050',
        	'usd_precio' => '18.150'
        ]);
    }
}