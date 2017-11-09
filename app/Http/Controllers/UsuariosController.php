<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Usuario;

class UsuariosController extends Controller
{
  public function index(){
    return view('cadUsuario');//->with(compact('usuarios'));
  }

  //public function listar(){
  //  return \response::json(Usuario::all(),200);
  //}
}
