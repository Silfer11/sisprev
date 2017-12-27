<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enquadramento extends Model
{
  protected $fillable = [
      'id', 'tipoAtivo', 'nome'
  ];

  protected $table = 'enquadramentos';

  public function Fundo(){
    return $this->belongsTo(Fundo::class, 'idEnq');
  }
}
