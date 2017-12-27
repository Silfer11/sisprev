<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimentacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->increments('id');

            $table->float('inicial', 8, 2)->nullable();
            $table->float('resgate', 8, 2)->nullable();
            $table->float('aplicacao', 8, 2)->nullable();
            $table->float('final', 8, 2)->nullable();

            $table->date('data');

            $table->integer('idFundo')->unsigned();
            $table->foreign('idFundo')->references('id')->on('fundos')->onDelete('cascade');

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
        Schema::dropIfExists('movimentacoes');
    }
}
