<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceitaDescricao extends Model
{
  protected $fillable = [
      'id', 'descricao'
  ];

  protected $table = 'receitasDescricoes';

  public function Receita(){
    return $this->belongsTo(Receita::class, 'idDescricao');
  }
}
