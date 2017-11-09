<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rpps extends Model
{
    protected $fillable = [
      'id', 'RPPS'
    ];

    protected $table = 'rpps';

    public function usuario(){
      return $this->hasMany(Usuario::class, 'idRPPS');
    }
}
