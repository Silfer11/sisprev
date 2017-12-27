<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Enquadramento;

class EnquadramentosController extends Controller
{
    public function listar(){
      return \Response::json(Enquadramento::all(),200);
    }

    public function registrar(Request $request){
      Enquadramento::create($request->all());
    }
}
