<?php

use App\Models\Rubro;
use Illuminate\Database\Seeder;

class RubroTableSeeder extends Seeder
{
    public function run()
    {
		Rubro::create([
			'denominacion' => 'CABLES',
        ]);
		Rubro::create([
			'denominacion' => 'MOUSES',
        ]);
		Rubro::create([
			'denominacion' => 'TECLADOS',
        ]);
    }
}
