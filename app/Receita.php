<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    protected $fillable = [
        'id', 'descricao', 'origem', 'aliq', 'parcela', 'valDevido', 'data', 'observacoes', 'idRPPS'
    ];

    protected $table = 'receitas';

    public function rpps(){
      return $this->belongsTo(rpps::class, 'idRPPS');
    }
}
