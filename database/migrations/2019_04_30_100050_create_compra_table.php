<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompraTable extends Migration
{
    public function up()
    {
        Schema::create('compra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('estado', ['ACTIVO', 'BAJA']);
            $table->enum('cbte_tipo', ['FAC-A', 'FAC-B', 'FAC-C', 'FAC-M', 'NDE-A', 'NDE-B', 'NDE-C', 'NDE-M', 'NCR-A', 'NCR-B', 'NCR-C', 'NCR-M', 'REM-R', 'REM-X' ]);
            $table->string('cbte_tpv', 5);
            $table->integer('cbte_nro');
            $table->dateTime('cbte_fecha');
            $table->unsignedBigInteger('proveedor_id');
            $table->double('ar_subtotal', 9, 2);
            $table->double('ar_descuento_taza', 6, 3);
            $table->double('ar_descuento_monto', 9, 2);
            $table->double('ar_iva105', 9, 2);
            $table->double('ar_iva210', 9, 2);
            $table->double('ar_iva270', 9, 2);
            $table->double('ar_total', 9, 2);
            $table->timestamps();

            $table->foreign('proveedor_id')->references('id')->on('proveedor');
        });
    }

    public function down()
    {
        Schema::dropIfExists('compra');
    }
}