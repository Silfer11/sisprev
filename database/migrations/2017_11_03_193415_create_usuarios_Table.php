<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');

            $table->string('usuario',50)->unique();
            $table->string('senha', 50);
            $table->string('nome', 50);
            $table->string('cpf', 11)->unique();
            $table->string('email', 50)->unique();

            $table->boolean('permAdmin');
            $table->boolean('permGRec');
            $table->boolean('permGFin');
            $table->boolean('permLogs');

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
        Schema::dropIfExists('usuarios');
    }
}
