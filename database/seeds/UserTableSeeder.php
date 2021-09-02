<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'sesion' => 'ADMIN',
            'denominacion' => 'REGALADO ALESSI SERGIO',
            'email' => 'regalado.alessi@gmail.com',
            'password'  => bcrypt('Sergito1'),
        ]);
        User::create([
            'sesion' => 'GREMIO',
            'denominacion' => 'AGUIRRE MARCELA EDITH',
            'email' => 'marce@gamil.com',
            'password'  => bcrypt('tortuga1'),
        ]);
    }
}
