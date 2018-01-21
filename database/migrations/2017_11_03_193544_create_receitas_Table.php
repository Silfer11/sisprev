<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receitas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('idDescricao')->unsigned();
            $table->foreign('idDescricao')->references('id')->on('receitasDescricoes')->onDelete('cascade');

            $table->string('origem', 50);
            $table->float('aliq', 53, 3)->nullable();
            $table->integer('parcela')->nullable();
            $table->float('valDevido', 53, 3);
            $table->date('data');
            $table->string('observacoes', 50)->nullable();

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
        Schema::dropIfExists('receitas');
    }
}
