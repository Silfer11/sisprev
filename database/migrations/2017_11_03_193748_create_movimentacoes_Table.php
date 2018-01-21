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

            $table->float('inicial', 53, 3)->nullable();
            $table->float('resgate', 53, 3)->nullable();
            $table->float('aplicacao', 53, 3)->nullable();
            $table->float('final', 53, 3)->nullable();

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
