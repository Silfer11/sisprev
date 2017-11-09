<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDespesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despesas', function (Blueprint $table) {
            $table->increments('id');

            $table->string('descricao', 50);
            $table->float('valor', 8, 2);
            $table->date('data');

            $table->integer('idCategoria')->unsigned();
            $table->foreign('idCategoria')->references('id')->on('despesasCategorias')->onDelete('cascade');

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
        Schema::dropIfExists('despesas');
    }
}
