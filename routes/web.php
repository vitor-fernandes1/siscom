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

Route::get('/', 'Site\SiteController@index')->name('home');

Route::group( [ ], function(){
    Route::get('empresa', 'Api\EmpresaController@index')->name('empresa.index');
    Route::post('empresa', 'Api\EmpresaController@store')->name('empresa.store');
    Route::get('empresa/pesquisar', 'Api\EmpresaController@update')->name('empresa.update');
    Route::get('empresa/deletar', 'Api\EmpresaController@delete')->name('empresa.delete');
});

Route::group( [ ], function(){
    Route::get('equipamento', 'Api\EquipamentoController@index')->name('equipamento.index');
    Route::post('equipamento', 'Api\EquipamentoController@store')->name('equipamento.store');
    Route::get('equipamento/pesquisar', 'Api\EquipamentoController@update')->name('equipamento.update');
    Route::get('equipamento/deletar', 'Api\EquipamentoController@delete')->name('equipamento.delete');
});

Route::group( [ ], function(){
    Route::get('manutencao', 'Api\ManutencaoController@index')->name('manutencao.index');
    Route::post('manutencao', 'Api\ManutencaoController@store')->name('manutencao.store');
    Route::get('manutencao/pesquisar', 'Api\ManutencaoController@update')->name('manutencao.update');
    Route::get('manutencao/deletar', 'Api\ManutencaoController@delete')->name('manutencao.delete');
});

Auth::routes();

