<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');


// Route::get('/', function () {
//     return view('home');
// });
//
// Route::get('/', 'HomeController@index');
//
// Route::get('/home', 'HomeController@index');
//
// //usuario
//
// Route::get('/Usuarios', 'UsuariosController@telaLista');
//
// Route::get('/CadastrarUsuarios', 'UsuariosController@telaCadastro');
//
// Route::get('/AtualizarUsuarios/{id}', 'UsuariosController@telaAtualizacao');
//
// //receita
//
// Route::get('/Receitas', 'ReceitasController@telaLista');

//despesa

// Route::get('/Despesa', 'DespesasController@telaLista');
