<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'id', 'usuario', 'senha', 'nome', 'cpf', 'email', 'permAdmin', 'permGRec', 'permGFin', 'permLogs', 'idRPPS'
    ];

    protected $table = 'usuarios';

    public function rpps(){
      return $this->belongsTo(rpps::class, 'idRPPS');
    }
}
