<?php

use App\Models\Compra;
use Illuminate\Database\Seeder;

class CompraTableSeeder extends Seeder
{
    public function run()
    {
        Compra::create([
        	'estado' => 'ACTIVO',
        	'cbte_tipo' => 'FAC-C',
        	'cbte_tpv' => '00001',
        	'cbte_nro' => '1',
        	'cbte_fecha' => '2019-02-01',
        	'proveedor_id' => '1',
        	'ar_subtotal' => '1000.00',
        	'ar_descuento_taza' => '10.000',
        	'ar_descuento_monto' => '100.00',
        	'ar_iva105' => '0.00',
        	'ar_iva210' => '189.00',
        	'ar_iva270' => '0.00',
        	'ar_total' => '1089.00'
        ]);
    }
}