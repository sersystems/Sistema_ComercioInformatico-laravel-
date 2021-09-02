<?php

use App\Models\Venta;
use Illuminate\Database\Seeder;

class VentaTableSeeder extends Seeder
{
    public function run()
    {
        Venta::create([
        	'estado' => 'ACTIVO',
        	'cbte_tipo' => 'FAC-C',
        	'cbte_tpv' => '00001',
        	'cbte_nro' => '1',
        	'cbte_fecha' => '2019-01-01',
        	'cliente_id' => '1',
        	'ar_subtotal' => '1000.00',
        	'ar_descuento_taza' => '10.000',
        	'ar_descuento_monto' => '100.00',
        	'ar_iva105' => '0.00',
        	'ar_iva210' => '189.00',
        	'ar_iva270' => '0.00',
        	'ar_total' => '1089.00',
        	'ar_costo' => '500.00',
        	'ar_margen' => '215.25'
        ]);
    }
}
