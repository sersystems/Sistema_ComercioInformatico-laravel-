<?php

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteTableSeeder extends Seeder
{
    public function run()
    {
		Cliente::create([
			'apellido' => 'ALESSI',
			'nombre' => 'ROSA LIDIA',
			'cuit' => '00056438200',
			'iva' => 'CONSUMIDOR FINAL',
			'domicilio' => 'XXX 123',
			'provincia' => 'SAN JUAN',
			'distrito' => 'RAWSON',
			'cp' => '5400',
			'telefono' => '4241354',
			'celular1' => '',
			'celular2' => '',
			'email' => 'rosa@rosa.com',
			'lista_precio' => 'P.PUBLICO',
			'saldo' => '0.00',
			'estado' => 'ACTIVO'
		]);
		
		Cliente::create([
			'apellido' => 'PAEZ',
			'nombre' => 'PABLO ARIEL',
			'cuit' => '20256438209',
			'iva' => 'CONSUMIDOR FINAL',
			'domicilio' => 'CALLE 123',
			'provincia' => 'SAN JUAN',
			'distrito' => 'CHIMBAS',
			'cp' => '5420',
			'telefono' => '',
			'celular1' => '2645885577',
			'celular2' => '',
			'email' => '',
			'lista_precio' => 'P.GREMIO',
			'saldo' => '-100.00',
			'estado' => 'ACTIVO'
        ]);
    }
}