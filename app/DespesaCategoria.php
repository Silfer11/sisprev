<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DespesaCategoria extends Model
{
    protected $fillable = [
        'id', 'categoria'
    ];

    protected $table = 'despesascategorias';

    public function Despesa(){
      return $this->belongsTo(Despesa::class, 'idCategoria');
    }

    public function despesa(){
      return $this->has(Despesa::class, 'id');
    }
}
