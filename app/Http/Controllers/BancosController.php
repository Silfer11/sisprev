<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Banco;

class BancosController extends Controller
{
    public function listar(){
      return \Response::json(Banco::all(),200);
    }

    public function registrar(Request $request){
      Banco::create($request->all());
    }
}
