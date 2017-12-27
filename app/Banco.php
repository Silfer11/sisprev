<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
  protected $fillable = [
      'id', 'nome'
  ];

  protected $table = 'bancos';

  public function Fundo(){
    return $this->belongsTo(Fundo::class, 'idBanco');
  }
}
