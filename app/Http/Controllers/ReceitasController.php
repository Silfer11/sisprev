<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Receita;

class ReceitasController extends Controller
{
    public function listar(Request $request){

      // o primeiro dia do mês hard coded
      $dateStart = date("Y-m-01", strtotime($request->date));

      // t é equivalente ao último dia do mês
      $dateEnd = date("Y-m-t", strtotime($request->date));

      return \Response::json(Receita::with('ReceitaDescricao')->whereBetween('data', [ $dateStart , $dateEnd ])->get(),200);
    }

    public function registrar(Request $request){
      Receita::create($request->all());
    }

    public function excluir(Request $request){
      Receita::destroy($request->id);
    }

     public function atualizar(Request $request){
      $receita = Receita::find($request->id);

      if($receita->idDescricao !== $request->idDescricao)
        $receita->idDescricao = $request->idDescricao;

      if($receita->origem !== $request->origem)
        $receita->origem = $request->origem;

      if($receita->aliq !== $request->aliq)
        $receita->aliq = $request->aliq;

      if($receita->parcela !== $request->parcela)
        $receita->parcela = $request->parcela;

      if($receita->valDevido !== $request->valDevido)
        $receita->valDevido = $request->valDevido;

      if($receita->data !== $request->data)
        $receita->data = $request->data;

      if($receita->observacoes !== $request->observacoes)
        $receita->observacoes = $request->observacoes;

      if($receita->idRPPS !== $request->idRPPS)
          $receita->idRPPS = $request->idRPPS;

      $receita->save();
    }
}
