<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticuloTable extends Migration
{
    public function up()
    {
        Schema::create('articulo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo', 30);
            $table->string('marca', 13);
            $table->string('modelo', 13);
            $table->string('descripcion', 250)->nullable();
            $table->unsignedBigInteger('rubro_id');
            $table->string('codigo_barras', 25)->nullable();
            $table->enum('garantia', ['S/D', '72hs', '30d', '90d', '180d', '360d']);
            $table->enum('unidad', ['KGS', 'LTS', 'MTS', 'PAQ', 'UNI']);
            $table->integer('stock');
            $table->integer('stock_minimo');
            $table->integer('stock_maximo');
            $table->double('usd_costo_bruto', 9, 3);
            $table->double('iva_alicuota', 5, 2);
            $table->double('usd_iva_base', 9, 3);
            $table->double('usd_costo_neto', 9, 3);
            $table->double('utilidad', 6, 3);
            $table->double('usd_margen', 9, 3);
            $table->double('usd_precio', 9, 3);
            $table->string('imagen_nombre', 50)->default('art_default.jpg');
            $table->enum('estado', ['ACTIVO', 'BAJA']);
            $table->timestamps();

            $table->foreign('rubro_id')->references('id')->on('rubro');
        });
    }

    public function down()
    {
        Schema::dropIfExists('articulo');
    }
}