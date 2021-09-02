<?php

use App\Models\Mensaje;
use Illuminate\Database\Seeder;

class MensajeTableSeeder extends Seeder
{
    public function run()
    {
		Mensaje::create([
			'denominacion' => 'PEPE ANDRADE',
			'celular' => '2645778855',
			'email' => 'prueba1@prueba.com',
            'consulta' => 'Esta es una consulta automatica nro. 1',
            'respuesta' => 'Esta es la respuesta automatica nro. 1',
            'estado' => 'RESPONDIDO'
        ]);
		Mensaje::create([
			'denominacion' => 'ROBERTO PEREZ',
			'celular' => '2645778844',
			'email' => 'prueba2@prueba.com',
            'consulta' => 'Esta es una consulta automatica nro. 2',
            'respuesta' => '',
            'estado' => 'S/RESPONDER'
        ]);
	}
}