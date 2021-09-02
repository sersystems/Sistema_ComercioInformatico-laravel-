<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRubroTable extends Migration
{
    public function up()
    {
        Schema::create('rubro', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('denominacion', 30)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rubro');
    }
}
