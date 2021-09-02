<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensajeTable extends Migration
{
    public function up()
    {
        Schema::create('mensaje', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('denominacion', 35)->index();
            $table->string('celular', 13);
            $table->string('email', 50);
            $table->string('consulta', 250);
            $table->string('respuesta', 250)->nullable();
            $table->enum('estado', ['RESPONDIDO', 'S/RESPONDER']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mensaje');
    }
}
