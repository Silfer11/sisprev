<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Usuario;

class UsuariosController extends Controller
{
  public function listar(){
    return \Response::json(Usuario::all(),200);
  }

  public function registrar(Request $request){
    Usuario::create($request->all());
  }

  public function excluir(Request $request){
    Usuario::destroy($request->id);
  }

  public function atualizar(Request $request){
    $user = Usuario::find($request->id);

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
