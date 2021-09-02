<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
      $this->vaciarTabla([
        'users',
        'rubro',
        'articulo',
        'cliente',
        'proveedor',
        'compra',
        'compra_detalle',
        'venta',
        'venta_detalle',
        'mensaje',
      ]);

      $this->call([
        UserTableSeeder::class,
        RubroTableSeeder::class,
        ArticuloTableSeeder::class,
        ClienteTableSeeder::class,
        ProveedorTableSeeder::class,
        CompraTableSeeder::class,
        CompraDetalleTableSeeder::class,
        VentaTableSeeder::class,
        VentaDetalleTableSeeder::class,
        MensajeTableSeeder::class,
      ]);
    }

    private function vaciarTabla(array $tablas)
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	foreach ($tablas as $tabla)
    	{
  			DB::table($tabla)->truncate();
    	}
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');   	
    }
}
