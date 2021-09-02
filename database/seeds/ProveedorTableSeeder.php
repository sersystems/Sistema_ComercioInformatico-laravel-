<?php

use App\Models\Proveedor;
use Illuminate\Database\Seeder;

class ProveedorTableSeeder extends Seeder
{
    public function run()
    {
		Proveedor::create([
			'denominacion' => 'ELIT SA',
			'cuit' => '30256438201',
			'iva' => 'RESPONSABLE INSCRIPTO',
			'domicilio' => 'XXX 123 as',
			'provincia' => 'MENDOZA',
			'distrito' => 'CAPITAL',
			'cp' => '5200',
			'telefono' => '',
			'celular1' => '02645885599',
			'celular2' => '',
			'email' => 'elit@elit.com',
			'saldo' => '0.00',
			'estado' => 'ACTIVO',
        ]);
    }
}
