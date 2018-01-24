<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Movimentacao;
use App\LogMovimentacao;

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
    $movimentacao_inicial->inicial = 0;
    $movimentacao_inicial->resgate = 0;
    $movimentacao_inicial->aplicacao = 0;
    $movimentacao_inicial->final = 0;

    $movimentacao_inicial->save();
  }

  public function excluir(Request $request){
    Movimentacao::destroy($request->id);
  }

  public function movimentar(Request $request){
    $movimentacao_log = new LogMovimentacao();

    $movimentacao_aplicacao = Movimentacao::find($request->idFunApl);
    $movimentacao_resgate = Movimentacao::find($request->idFunRes);

    $movimentacao_log->idFunApl = $request->idFunApl;
    $movimentacao_log->idFunRes = $request->idFunRes;
    $movimentacao_log->data = $request->date;
    $movimentacao_log->valor = $request->valor;
    $movimentacao_log->idRPPS =$request->idRPPS;

    $movimentacao_aplicacao->aplicacao = $movimentacao_aplicacao->aplicacao + $request->valor;
    $movimentacao_resgate->resgate = $movimentacao_resgate->resgate + $request->valor;


    $movimentacao_aplicacao->save();
    $movimentacao_resgate->save();
    $movimentacao_log->save();
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
