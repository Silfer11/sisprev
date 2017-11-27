<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//usuarios

Route::get('/usuarios/listar','UsuariosController@pegaUsuarios');

Route::post('/usuarios/cadastrar', 'UsuariosController@registrar');

Route::post('/usuarios/excluir/{id}', 'UsuariosController@excluir');

Route::get('/usuarios/procurar/{id}', 'UsuariosController@procurar');

Route::post('/usuarios/atualizar', 'UsuariosController@atualizar');

//receitas

Route::get('/receitas/listar','ReceitasController@pegaReceitas');

Route::post('/receitas/cadastrar', 'ReceitasController@registrar');

Route::post('/receitas/excluir/{id}', 'ReceitasController@excluir');
