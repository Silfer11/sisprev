<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    protected $fillable = [
        'id', 'idDescricao', 'origem', 'aliq', 'parcela', 'valDevido', 'data', 'observacoes', 'idRPPS'
    ];

    protected $table = 'receitas';

    public function ReceitaDescricao(){
      return $this->belongsTo(ReceitaDescricao::class, 'idDescricao');
    }

    public function rpps(){
      return $this->belongsTo(rpps::class, 'idRPPS');
    }
}
