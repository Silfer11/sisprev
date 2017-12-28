<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Movimentacao;

class MovimentacoesController extends Controller
{
  public function listar(Request $request){
    $date = date("Y-m-d", strtotime($request->date));

    return \Response::json(Movimentacao::with('Fundo.Banco', 'Fundo.Enquadramento')->where('data', '=', $date)->get(),200);
  }
  
  public function registrar(Request $request){

    $movimentacao_inicial = new Movimentacao();
    $movimentacao_inicial->idFundo = $request->id;
    $movimentacao_inicial->data = date('Y-m-d');

    $movimentacao_inicial->save();
  }

  public function excluir(Request $request){
    Movimentacao::destroy($request->id);
  }

   public function atualizar(Request $request){
    $movimentacao = Movimentacao::find($request->id);

    if($movimentacao->inicial !== $request->inicial)
      $movimentacao->inicial = $request->inicial;

    if($movimentacao->resgate !== $request->resgate)
      $movimentacao->resgate = $request->resgate;

    if($movimentacao->aplicacao !== $request->aplicacao)
      $movimentacao->aplicacao = $request->aplicacao;

    if($movimentacao->final !== $request->final)
        $movimentacao->final = $request->final;

    $movimentacao->save();
  }
}
