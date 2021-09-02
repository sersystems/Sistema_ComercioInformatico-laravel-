<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompraDetalleTable extends Migration
{
    public function up()
    {
        Schema::create('compra_detalle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('compra_id');
            $table->unsignedBigInteger('articulo_id');
            $table->string('denominacion', 53);
            $table->enum('garantia', ['S/D', '72hs', '30d', '90d', '180d', '360d']);
            $table->integer('cantidad');
            $table->double('usd_costo_bruto', 9, 3);
            $table->double('iva_alicuota', 5, 2);
            $table->double('usd_iva_base', 9, 3);
            $table->double('usd_costo_neto', 9, 3);
            $table->double('utilidad', 6, 3);
            $table->double('usd_margen', 9, 3);
            $table->double('usd_precio', 9, 3);
            $table->timestamps();

            $table->foreign('compra_id')->references('id')->on('compra');
        });
    }

    public function down()
    {
        Schema::dropIfExists('compra_detalle');
    }
}