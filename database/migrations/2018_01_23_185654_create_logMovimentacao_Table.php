<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogMovimentacaoTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('logMovimentacao', function (Blueprint $table) {
          $table->increments('id');

          $table->date('data');

          $table->integer('idFunApl')->unsigned();
          $table->foreign('idFunApl')->references('id')->on('fundos')->onDelete('cascade');

          $table->integer('idFunRes')->unsigned();
          $table->foreign('idFunRes')->references('id')->on('fundos')->onDelete('cascade');

          $table->float('valor', 53, 3);

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
      Schema::dropIfExists('movimentacoes');
  }
}
