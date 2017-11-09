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

            $table->string('descricao', 50);
            $table->string('origem', 50);
            $table->float('aliq', 8, 2);
            $table->integer('parcela');
            $table->float('valDevido', 8, 2);
            $table->date('data');
            $table->string('observacoes', 50);

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
