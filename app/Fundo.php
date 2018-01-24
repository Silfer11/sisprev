<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fundo extends Model
{
    protected $fillable = [
        'id', 'contContab', 'nome', 'cnpj', 'indReferencia', 'conta',
        'nivelRisco', 'risco', 'idBanco', 'idEnq', 'idRPPS'
    ];

    protected $table = 'fundos';

    public function Banco(){
      return $this->belongsTo(Banco::class, 'idBanco');
    }

    public function Enquadramento(){
      return $this->belongsTo(Enquadramento::class, 'idEnq');
    }

    public function rpps(){
      return $this->belongsTo(rpps::class, 'idRPPS');
    }
}
