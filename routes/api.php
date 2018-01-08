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

//Logar

Route::post('/logar/funcionario','UsuariosController@logar');

//usuarios

Route::get('/usuarios/listar','UsuariosController@listar');

Route::post('/usuarios/cadastrar', 'UsuariosController@registrar');

Route::post('/usuarios/excluir/{id}', 'UsuariosController@excluir');

Route::post('/usuarios/atualizar', 'UsuariosController@atualizar');

//receitas

Route::get('/receitas/listar','ReceitasController@listar');

Route::post('/receitas/cadastrar', 'ReceitasController@registrar');

Route::post('/receitas/atualizar', 'ReceitasController@atualizar');

Route::post('/receitas/excluir/{id}', 'ReceitasController@excluir');

//receitas descricoes

Route::get('/receitas/descricoes/listar', 'ReceitasDescricoesController@listar');

Route::post('/receitas/descricoes/cadastrar', 'ReceitasDescricoesController@registrar');

//despesas

Route::get('/despesas/listar','DespesasController@listar');

Route::post('/despesas/cadastrar', 'DespesasController@registrar');

Route::post('/despesas/atualizar', 'DespesasController@atualizar');

Route::post('/despesas/excluir/{id}', 'DespesasController@excluir');

//despesas categorias

Route::get('/despesas/categorias/listar', 'DespesasCategoriasController@listar');

Route::post('/despesas/categorias/cadastrar', 'DespesasCategoriasController@registrar');

//fundos

Route::get('/fundos/listar', 'FundosController@listar');

Route::post('/fundos/cadastrar', 'FundosController@registrar');

Route::post('/fundos/atualizar', 'FundosController@atualizar');

Route::post('/fundos/excluir/{id}', 'FundosController@excluir');

//movimentacoes financeiras

Route::get('/fundos/movimentacoes/listar', 'MovimentacoesController@listar');

Route::post('/fundos/movimentacoes/cadastrar', 'MovimentacoesController@registrar');

Route::post('/fundos/movimentacoes/atualizar', 'MovimentacoesController@atualizar');

//bancos

Route::get('/fundos/bancos/listar', 'BancosController@listar');

Route::post('/fundos/bancos/cadastrar', 'BancosController@registrar');

//enquadramentos

Route::get('/fundos/enquadramentos/listar', 'EnquadramentosController@listar');

Route::post('/fundos/enquadramentos/cadastrar', 'EnquadramentosController@registrar');
