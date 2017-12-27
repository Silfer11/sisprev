<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Fundo;

class FundosController extends Controller
{
    public function listar(){
      return \Response::json(Fundo::with('Banco', 'Enquadramento')->get(),200);
    }

    public function registrar(Request $request){
      $fundo_temp = Fundo::create($request->all());
      return $fundo_temp->id;
    }

    public function excluir(Request $request){
      Fundo::destroy($request->id);
    }

     public function atualizar(Request $request){
      $fundo = Fundo::find($request->id);

      if($fundo->contContab !== $request->contContab)
        $fundo->contContab = $request->contContab;

      if($fundo->nome !== $request->nome)
        $fundo->nome = $request->nome;

      if($fundo->CNPJ !== $request->CNPJ)
        $fundo->CNPJ = $request->CNPJ;

      if($fundo->segmento !== $request->segmento)
        $fundo->segmento = $request->segmento;

      if($fundo->indReferencia !== $request->indReferencia)
          $fundo->indReferencia = $request->indReferencia;

      if($fundo->conta !== $request->conta)
          $fundo->conta = $request->conta;

      if($fundo->nivelRisco !== $request->nivelRisco)
          $fundo->nivelRisco = $request->nivelRisco;

      if($fundo->risco !== $request->risco)
          $fundo->risco = $request->risco;

      if($fundo->idBanco !== $request->idBanco)
          $fundo->idBanco = $request->idBanco;

      if($fundo->idEnq !== $request->idEnq)
          $fundo->idEnq = $request->idEnq;

      if($fundo->idRPPS !== $request->idRPPS)
          $fundo->idRPPS = $request->idRPPS;

      $fundo->save();
    }
}
