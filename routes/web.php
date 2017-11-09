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
Route::get('/', function () {
    return view('home');
});

Route::get('/', ['as' => 'home.index', 'uses' => 'HomeController@index']);

Route::get('/home', ['as' => 'home.index', 'uses' => 'HomeController@index']);

Route::get('/Usuarios', ['as' => 'users.index', 'uses' => 'UsuariosController@index']);

Route::get('/CadastrarUsuarios', ['as' => 'users.index', 'uses' => 'UsuariosController@index']);
