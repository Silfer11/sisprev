<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\DespesaCategoria;

class DespesasCategoriasController extends Controller
{
    public function listar(){
      return \Response::json(DespesaCategoria::all(),200);
    }

    public function registrar(Request $request){
      DespesaCategoria::create($request->all());
    }
}
