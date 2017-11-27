<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rpps extends Model
{
    protected $fillable = [
      'id', 'RPPS'
    ];

    protected $table = 'rpps';

    public function usuario(){
      return $this->hasMany(Usuario::class, 'idRPPS');
    }

    public function receita(){
      return $this->hasMany(Receita::class, 'idRPPS');
    }

    public function despesa(){
      return $this->hasMany(Despesa::class, 'idRPPS');
    }
}
