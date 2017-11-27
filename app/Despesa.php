<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    protected $fillable = [
        'id', 'descricao', 'valor', 'data', 'idCategoria', 'idRPPS'
    ];

    protected $table = 'despesas';

    public function rpps(){
      return $this->belongsTo(rpps::class, 'idRPPS');
    }
}
