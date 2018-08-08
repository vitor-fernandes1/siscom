<?php

use Illuminate\Http\Request;

use App\Models\HistoricoCustas;
use App\Http\Resources\HistoricoCustasResource;

use App\Models\HistoricoMulta;
use App\Http\Resources\HistoricoMultaResource;

use App\Models\HistoricoServico;
use App\Http\Resources\HistoricoServicoResource;

use App\Models\HistoricoPecunia;
use App\Http\Resources\HistoricoPecuniaResource;


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


Route::group([], function(){
    

    Route::resources([
        'apenados'          => 'Api\ApenadoController',
        'custas'            => 'Api\CustasController',
        'historico-custas'  => 'Api\HistoricoCustasController',
        'historico-multas'  => 'Api\HistoricoMultaController',
        'historico-servicos'=> 'Api\HistoricoServicoController',
        'historico-pecunias'=> 'Api\HistoricoPecuniaController',
        'enderecos'         => 'Api\EnderecoController',
        'entidades'         => 'Api\EntidadeController',
        'frequencias'       => 'Api\FrequenciaController',
        'motivos'           => 'Api\MotivoController',
        'multas'            => 'Api\MultaController',
        'opcoes'            => 'Api\OpcaoController', 
        'opcao-parametros'  => 'Api\OpcaoParametroController', 
        'pagamentos'        => 'Api\PagamentoController',
        'parametros'        => 'Api\ParametroController',
        'pecunias'          => 'Api\PecuniaController',
        'penas'             => 'Api\PenaController',
        'servicos'          => 'Api\ServicoController',
        'varas'             => 'Api\VaraController',
        'bancos'            => 'Api\BancoController'
    ]);

    Route::get('/enderecos/cep/{cep}', 'Api\EnderecoController@getEndereco');
    Route::get('/frequencias/servico/{id}/ano/{ano}/mes/{mes}', 'Api\FrequenciaController@showByDate');

    Route::post('/frequencias/{id}/excluir', 'Api\FrequenciaController@excluir');
    Route::post('/pagamentos/{id}/excluir', 'Api\PagamentoController@excluir');

    Route::post('/servicos/{id}/inativar', 'Api\ServicoController@ativarOuInativar');
    Route::post('/servicos/{id}/ativar', 'Api\ServicoController@ativarOuInativar');

    Route::post('/pecunias/{id}/inativar', 'Api\PecuniaController@ativarOuInativar');
    Route::post('/pecunias/{id}/ativar', 'Api\PecuniaController@ativarOuInativar');

    Route::post('/multas/{id}/inativar', 'Api\MultaController@ativarOuInativar');
    Route::post('/multas/{id}/ativar', 'Api\MultaController@ativarOuInativar');

    Route::post('/custas/{id}/inativar', 'Api\CustasController@ativarOuInativar');
    Route::post('/custas/{id}/ativar', 'Api\CustasController@ativarOuInativar');

    Route::post('/penas/{id}/inativar', 'Api\PenaController@ativarOuInativar');
    Route::post('/penas/{id}/ativar', 'Api\PenaController@ativarOuInativar');

    Route::post('/entidades/{id}/inativar', 'Api\EntidadeController@ativarOuInativar');
    Route::post('/entidades/{id}/ativar', 'Api\EntidadeController@ativarOuInativar');

    Route::post('/varas/{id}/inativar', 'Api\VaraController@ativarOuInativar');
    Route::post('/varas/{id}/ativar', 'Api\VaraController@ativarOuInativar');

    // Route::get('/lotas', 'LotacaoController@index');
    
    /*Route::get('/historico-custas', function(){
        return HistoricoCustasResource::collection(HistoricoCustas::all());
    });

    Route::get('/historico-multas', function(){
        return HistoricoMultaResource::collection(HistoricoMulta::all());
    });

    Route::get('/historico-servicos', function(){
        return HistoricoServicoResource::collection(HistoricoServico::all());
    });


    Route::get('/historico-pecunias', function(){
        return HistoricoPecuniaResource::collection(HistoricoPecunia::all());
    });*/




});

