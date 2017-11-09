<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Usuario;

class UsuariosController extends Controller
{
  public function listar(){
    return view('usuarios.Usuarios');//->with(compact('usuarios'));
  }

  public function cadastrar(){
    return view('usuarios.cadUsuario');//->with(compact('usuarios'));
  }

  public function pegaUsuarios(){
    return \Response::json(Usuario::all(),200);
  }
}
