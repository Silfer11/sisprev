<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DespesaCategoria extends Model
{
    protected $fillable = [
        'id', 'categoria'
    ];

    protected $table = 'despesasCategorias';

    public function Despesa(){
      return $this->belongsTo(Despesa::class, 'idCategoria');
    }
}
