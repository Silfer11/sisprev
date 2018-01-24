<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogMovimentacao extends Model
{
    protected $fillable = [
        'id', 'data', 'idFunApl', 'idFunRes', 'valor', 'idRPPS'
    ];

    protected $table = 'logMovimentacao';

    public function FundoAplicacao(){
      return $this->belongsTo(Fundo::class, 'idFunApl');
    }
    public function FundoResgate(){
      return $this->belongsTo(Fundo::class, 'idFunRes');
    }
    public function rpps(){
      return $this->belongsTo(rpps::class, 'idRPPS');
    }
}
