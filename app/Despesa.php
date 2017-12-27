<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    protected $fillable = [
        'id', 'descricao', 'valor', 'data', 'idCategoria', 'idRPPS'
    ];

    protected $table = 'despesas';

    public function DespesaCategoria(){
      return $this->belongsTo(DespesaCategoria::class, 'idCategoria');
    }

    public function rpps(){
      return $this->belongsTo(rpps::class, 'idRPPS');
    }
}
