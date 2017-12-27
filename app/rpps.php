<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rpps extends Model
{
    protected $fillable = [
      'id', 'RPPS'
    ];

    protected $table = 'rpps';

    public function Usuario(){
      return $this->hasMany(Usuario::class, 'idRPPS');
    }

    public function Receita(){
      return $this->hasMany(Receita::class, 'idRPPS');
    }

    public function Despesa(){
      return $this->hasMany(Despesa::class, 'idRPPS');
    }

    public function Fundo(){
      return $this->hasMany(Fundo::class, 'idRPPS');
    }
}
