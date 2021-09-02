<?php

use App\Models\Articulo;
use Illuminate\Database\Seeder;

class ArticuloTableSeeder extends Seeder
{
    public function run()
    {
        Articulo::create([
			'tipo' => 'MOUSE USB2.0',
			'marca' => 'GENIUS',
			'modelo' => 'GENMOU-42',
            'descripcion' => 'descripcion del producto 1',
			'rubro_id' => '1',
			'codigo_barras' => '00225544777',
			'garantia' => '90d',
			'unidad' => 'UNI',
			'stock' => '100',
        	'stock_minimo' => '15', 
        	'stock_maximo' => '75',
        	'usd_costo_bruto' => '10.0',
        	'iva_alicuota' => '21.00', 
        	'usd_iva_base' => '2.10',
        	'usd_costo_neto' => '12.10',
        	'utilidad' => '50.00', 
        	'usd_margen' => '6.05',
			'usd_precio' => '18.15',
			'imagen_nombre' => 'art_default.jpg',
        	'estado' => 'ACTIVO', 
        ]);

        Articulo::create([
			'tipo' => 'TECLADO USB2.0 SLIM',
			'marca' => 'PHILIPS',
			'modelo' => 'PHIX-T454',			
            'descripcion' => 'descripcion del producto 2',
			'rubro_id' => '3',
			'codigo_barras' => '01122024857',
			'garantia' => '180d',
        	'unidad' => 'UNI',
        	'stock' => '75',
        	'stock_minimo' => '25', 
        	'stock_maximo' => '55',
        	'usd_costo_bruto' => '5.0',
        	'iva_alicuota' => '27.00',
        	'usd_iva_base' => '1.35',
        	'usd_costo_neto' => '6.35',
        	'utilidad' => '100.00', 
        	'usd_margen' => '6.35',
        	'usd_precio' => '12.70',
			'imagen_nombre' => 'art_default.jpg',
        	'estado' => 'ACTIVO', 
        ]);

        Articulo::create([
			'tipo' => 'LECTOGRABADORA DVD USB',
			'marca' => 'SAMSUNG',
			'modelo' => 'LGS-024555',
            'descripcion' => 'descripcion del producto 1',
			'rubro_id' => '2',
			'codigo_barras' => '',
			'garantia' => '72hs',
        	'unidad' => 'UNI',
        	'stock' => '250',
        	'stock_minimo' => '5', 
        	'stock_maximo' => '85',
        	'usd_costo_bruto' => '50.00',
        	'iva_alicuota' => '10.50', 
        	'usd_iva_base' => '5.25',
        	'usd_costo_neto' => '55.25',
        	'utilidad' => '30.00', 
        	'usd_margen' => '16.575',
        	'usd_precio' => '71.825',
			'imagen_nombre' => 'art_default.jpg',
        	'estado' => 'ACTIVO', 
        ]);
    }
}
