<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    protected $fillable = [
        'id', 'inicial', 'resgate', 'aplicacao', 'final', 'data', 'idFundo'
    ];

    protected $table = 'movimentacoes';

    public function Fundo(){
      return $this->belongsTo(Fundo::class, 'idFundo');
    }
}
