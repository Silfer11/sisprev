<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ReceitaDescricao;

class ReceitasDescricoesController extends Controller
{
    public function listar(){
      return \Response::json(ReceitaDescricao::all(),200);
    }

    public function registrar(Request $request){
      ReceitaDescricao::create($request->all());
    }
}
