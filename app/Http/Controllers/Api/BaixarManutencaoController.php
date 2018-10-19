<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiControllerTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Manutencao;

class BaixarManutencaoController extends Controller
{
    
/**
     * <b>use ApiControllerTrait</b> Usa a trait e sobreescreve os seus nomes e sua visibilidade, para a classe
     * que esta utilizando a mesma. Sendo assim temos um método index neste classe e um na ApiControllerTrait. 
     * Para não causar conflito é alterado o seu nome exemplo: index as protected indexTrait;
     * Mais informações em: http://php.net/manual/en/language.oop5.traits.php (Changing Method Visibility)
    */
    use ApiControllerTrait
    {

        index as protected indexTrait;
        store as protected storeTrait;
        show as protected showTrait;
        update as protected updateTrait;
        destroy as protected destroyTrait;
    }
    /**
     * <b>model</b> Atributo responsável em guardar informações a respeito de qual model a controller ira utilizar. 
     * Por causa do D.I (injeção de dependencia feita) o mesmo armazena um objeto da classe que ira ser utilizada.
     * OBS: Este atributo é utilizado na ApiControllerTrait, para diferenciar qual classe esta utilizando os seus recursos
    */
    protected $model;

    /**
     * <b>__construct</b> Método construtor da classe. O mesmo é utilizado, para que atribuir qual a model será utilizada.
     * Essa informação atribuida aqui, fica disponivel na ApiControllerTrait e é utilizada pelos seus metodos.
    */
    public function __construct(Manutencao $model)
    {
        $this->model = $model;
    }
    /**
     * <b>index</b> Método responsável em receber a requisição do tipo GET e encaminhar a mesma para o metodo index da ApiControllerTrait
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //Buscando manutençoes não concluidas
        $obterManutencaoNaoConcluida = DB::select("SELECT pk_manutencao, ds_descricao_manutencao, dt_manutencao, vl_valor_manutencao, fk_pk_situacao FROM siscom_manutencao WHERE fk_pk_situacao > 0 AND fk_pk_situacao < 3");
        //dd($obterManutencaoNaoConcluida);
        return view('site.baixar-manutencao', compact('obterManutencaoNaoConcluida') );
    }
    /**
     * <b>show</b> Método responsável em receber a requisição do tipo GET contendo o id do recurso a ser consultado
     *  e encaminhar a mesma para o metodo index da ApiControllerTrait
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //obtendo dados do equipamento
        $recuperandoDados =  $this->showTrait($id);
        $recuperandoDados = $recuperandoDados->original['Resposta']['conteudo'] ;
        $idEmpresa = $recuperandoDados->fk_pk_empresa;
        $dadosEmpresa = DB::select("SELECT nm_empresa, ds_cnpj_empresa FROM siscom_empresa WHERE pk_empresa = $idEmpresa");
        
        return view('site.baixar-manutencao-id', compact('recuperandoDados', 'dadosEmpresa'));
        
    }
    /**
     * <b>show</b> Método responsável em receber a requisição do tipo GET contendo o id do recurso a ser consultado
     *  e encaminhar a mesma para o metodo index da ApiControllerTrait
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function avaliar($idManutencao, $avaliacao)
    {
        // 1- OTIMO 2- MEDIO 3- RUIM

        //Atualizando com a nota da avaliação da empresa
        $atualizarAvaliacaoEmpresa = DB::table('siscom_manutencao')->where('pk_manutencao', $idManutencao)->update(['fk_pk_avaliacao' => $avaliacao, 'fk_pk_situacao' => 3]);
        //dd($atualizarAvaliacaoEmpresa);
        return redirect()
                        ->route('baixar-manutencao.index')
                        ->with('success', "Equipamento baixado com suceso, avaliação incluida!");
        
    }

}
