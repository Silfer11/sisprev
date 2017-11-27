<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Receita;

class ReceitasController extends Controller
{
  public function telaLista(){
    return view('receitas.Receitas');//->with(compact('usuarios'));
  }

  public function pegaReceitas(){
    return \Response::json(Receita::all(),200);
  }

  public function registrar(Request $request){
    Receita::create($request->all());
  }

  public function excluir(Request $request){
    Receita::destroy($request->id);
  }

   public function atualizar(Request $request){
    $user = Receita::find($request->id);

    if($user->usuario !== $request->usuario)
      $user->usuario = $request->usuario;

    if($user->senha !== $request->senha)
      $user->senha = $request->senha;

    if($user->nome !== $request->nome)
      $user->nome = $request->nome;

    if($user->cpf !== $request->cpf)
      $user->cpf = $request->cpf;

    if($user->email !== $request->email)
      $user->email = $request->email;

    if($user->permAdmin !== $request->permAdmin)
      $user->permAdmin = $request->permAdmin;

    if($user->permGRec !== $request->permGRec)
      $user->permGRec = $request->permGRec;

    if($user->permGFin !== $request->permGFin)
      $user->permGFin = $request->permGFin;

    if($user->permLogs !== $request->permLogs)
      $user->permLogs = $request->permLogs;

    $user->save();
  }
}
