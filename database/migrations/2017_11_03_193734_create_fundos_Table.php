<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fundos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('contContab', 100);
            $table->string('nome', 50);
            $table->string('cnpj', 14);
            $table->string('indReferencia', 50);
            $table->string('conta', 100);
            $table->string('nivelRisco', 50);
            $table->string('risco', 50);

            $table->integer('idBanco')->unsigned();
            $table->foreign('idBanco')->references('id')->on('bancos')->onDelete('cascade');

            $table->integer('idEnq')->unsigned();
            $table->foreign('idEnq')->references('id')->on('enquadramentos')->onDelete('cascade');

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
        Schema::dropIfExists('fundos');
    }
}
