<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Despesa;

class DespesasController extends Controller
{
    public function listar(Request $request){

      // o primeiro dia do mês hard coded
      $dateStart = date("Y-m-01", strtotime($request->date));

      // t é equivalente ao último dia do mês
      $dateEnd = date("Y-m-t", strtotime($request->date));

      return \Response::json(Despesa::with('DespesaCategoria')->whereBetween('data', [ $dateStart , $dateEnd ])->get(),200);
    }

    public function registrar(Request $request){
      Despesa::create($request->all());
    }

    public function excluir(Request $request){
      Despesa::destroy($request->id);
    }

     public function atualizar(Request $request){
      $despesa = Despesa::find($request->id);

      if($despesa->descricao !== $request->descricao)
        $despesa->descricao = $request->descricao;

      if($despesa->valor !== $request->valor)
        $despesa->valor = $request->valor;

      if($despesa->data !== $request->data)
        $despesa->data = $request->data;

      if($despesa->idCategoria !== $request->idCategoria)
        $despesa->idCategoria = $request->idCategoria;

      if($despesa->idRPPS !== $request->idRPPS)
          $despesa->idRPPS = $request->idRPPS;

      $despesa->save();
    }
}
