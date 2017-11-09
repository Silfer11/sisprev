<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogAcessosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logAcessos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('cpf', 11);
            $table->datetime('dataEntrada');
            $table->datetime('dataSaida');

            $table->integer('idUsuario')->unsigned();
            $table->foreign('idUsuario')->references('id')->on('usuarios')->onDelete('cascade');

            $table->integer('idRPPS')->unsigned();
            $table->foreign('idRPPS')->references('id')->on('rpps')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logAcessos');
    }
}
