<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentaDetalleTable extends Migration
{
    public function up()
    {
        Schema::create('venta_detalle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('venta_id');
            $table->unsignedBigInteger('articulo_id');
            $table->string('denominacion', 53);
            $table->enum('garantia', ['S/D', '72hs', '30d', '90d', '180d', '360d']);
            $table->integer('cantidad');
            $table->double('ar_precio', 9, 2);
            $table->double('iva_alicuota', 5, 2);
            $table->double('ar_base', 9, 2);
            $table->double('ar_importe', 9, 2);
            $table->double('ar_costo', 9, 2);
            $table->timestamps();

            $table->foreign('venta_id')->references('id')->on('venta');
        });
    }

    public function down()
    {
        Schema::dropIfExists('venta_detalle');
    }
}
