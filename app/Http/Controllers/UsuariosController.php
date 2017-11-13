<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Usuario;

class UsuariosController extends Controller
{
  public function telaLista(){
    return view('usuarios.Usuarios');//->with(compact('usuarios'));
  }

  public function telaCadastro(){
    return view('usuarios.cadUsuario');//->with(compact('usuarios'));
  }

  public function pegaUsuarios(){
    return \Response::json(Usuario::all(),200);
  }

  public function registraUsuario(Request $request){
    Usuario::create($request->all());
  }

  public function procuraUsuario(Request $request){
    return \Response::json(Usuario::where('','like',$request));
  }

  public function updateUsuario(Request $request){

  }

}
