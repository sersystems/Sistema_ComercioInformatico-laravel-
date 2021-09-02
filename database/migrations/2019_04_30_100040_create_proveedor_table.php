<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorTable extends Migration
{
    public function up()
    {
        Schema::create('proveedor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('denominacion', 35)->index();
            $table->bigInteger('cuit')->unique();
            $table->enum('iva', ['RESPONSABLE INSCRIPTO', 'RESPONSABLE MONOTRIBUTO', 'SUJETO EXENTO']);
            $table->string('domicilio', 50);
            $table->string('provincia', 20);
            $table->string('distrito', 20);
            $table->string('cp', 5);
            $table->string('telefono', 13)->nullable();
            $table->string('celular1', 13)->nullable();
            $table->string('celular2', 13)->nullable();
            $table->string('email', 50)->nullable();
            $table->double('saldo', 9, 2);
            $table->enum('estado', ['ACTIVO', 'BAJA']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedor');
    }
}
