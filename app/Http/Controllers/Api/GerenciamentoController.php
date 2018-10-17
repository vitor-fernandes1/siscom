<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiControllerTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Equipamento;

class GerenciamentoController extends Controller
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
    public function __construct(Equipamento $model)
    {
        $this->model = $model;
    }
    /**
     * <b>index</b> Método responsável em receber a requisição do tipo GET e encaminhar a mesma para o metodo index da ApiControllerTrait
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $recuperandoDados = DB::table('siscom_equipamento')->get();
        //$recuperandoDados = $this->model->get();
        //dd($recuperandoDados);
        return view('site.gerenciamento', compact('recuperandoDados') );
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

        //Obtendo os dias de uso do equipamento
        $obterDiasdeUsoEquipamento = DB::select("SELECT TIMESTAMPDIFF(DAY,DT_COMPRA_EQUIPAMENTO,NOW()) AS dias FROM SISCOM_EQUIPAMENTO WHERE PK_EQUIPAMENTO = $id ");
        if(!empty($obterDiasdeUsoEquipamento))
        {
            $diasUsoEquipamento = $obterDiasdeUsoEquipamento['0']->dias ;
        }else{
            $diasUsoEquipamento = null ;
        }

        //Obtendo meses de uso do equipamento
        $obterMesesdeUsoEquipamento = DB::select("SELECT TIMESTAMPDIFF(MONTH,DT_COMPRA_EQUIPAMENTO,NOW()) AS meses FROM SISCOM_EQUIPAMENTO WHERE PK_EQUIPAMENTO = $id ");
        if(!empty($obterDiasdeUsoEquipamento))
        {
            $mesesUsoEquipamento = $obterMesesdeUsoEquipamento['0']->meses ;
        }else{
            $mesesUsoEquipamento = null ;
        }

        //Obtendo anos de uso do equipamento
        $obterAnosdeUsoEquipamento = DB::select("SELECT TIMESTAMPDIFF(YEAR,DT_COMPRA_EQUIPAMENTO,NOW()) AS anos FROM SISCOM_EQUIPAMENTO WHERE PK_EQUIPAMENTO = $id ");
        if(!empty($obterDiasdeUsoEquipamento))
        {
            $anosUsoEquipamento = $obterAnosdeUsoEquipamento['0']->anos ;
        }else{
            $anosUsoEquipamento = null ;
        }

        /** Barra de progresso será setada de acordo com a quantidade de manutenções realizadas no equipamento, seguindo a regra:
         * Cada manutenção reduzirá 5% de vida util do equipamento
         * Se a manutenção ocorrer no intervalo de 1 ano da data de compra do equipamento será acreascido 20% de redução a cada manutenção deste periodo
         * Se a manutenção ocorrer no intervalo de 6 meses da data de compra do equipamento será acreascido 40% de redução a cada manutenção deste periodo
         */
        $porcentagemBarra = 100;

        //Quantidade de mautenções realizadas
        $qtdManutencao = DB::table('siscom_manutencao')->where('fk_pk_equipamento', $id)->count();

        //calculado a qtd de manutenções para reduzir do percentual da barra
        $porcentagemBarra = $porcentagemBarra - ($qtdManutencao * 5);

        //Quantidade de manutenções em 1 ano
        $obterQtdManutencaoAno = DB::select("SELECT COUNT(p1.pk_equipamento) as registros FROM siscom_equipamento p1 INNER JOIN siscom_manutencao p2 ON p2.fk_pk_equipamento = p1.pk_equipamento WHERE p1.pk_equipamento = $id AND p2.fk_pk_equipamento = $id AND TIMESTAMPDIFF(DAY,p1.DT_COMPRA_EQUIPAMENTO, p2.DT_MANUTENCAO) > 180 AND TIMESTAMPDIFF(DAY,p1.DT_COMPRA_EQUIPAMENTO, p2.DT_MANUTENCAO) <= 365  ");
        if(!empty($obterQtdManutencaoAno))
        {
            $qtdManutencaoAno = $obterQtdManutencaoAno['0']->registros ;
        }else{
            $qtdManutencaoAno = null ;
        }
        //calculado a qtd de manutenções no periodo de 1 ano para reduzir do percentual da barra
        $porcentagemBarra = $porcentagemBarra - ($qtdManutencaoAno * 20);

        //Quantidade de manutenções em 6 meses
        $obterQtdManutencaoMes = DB::select("SELECT COUNT(p1.pk_equipamento) as registros FROM siscom_equipamento p1 INNER JOIN siscom_manutencao p2 ON p2.fk_pk_equipamento = p1.pk_equipamento WHERE p1.pk_equipamento = $id AND p2.fk_pk_equipamento = $id AND TIMESTAMPDIFF(DAY,p1.DT_COMPRA_EQUIPAMENTO, p2.DT_MANUTENCAO) <= 180 ");
        if(!empty($obterQtdManutencaoMes))
        {
            $qtdManutencaoMes = $obterQtdManutencaoMes['0']->registros ;
        }else{
            $qtdManutencaoMes = null ;
        }
        //calculado a qtd de manutenções no periodo de 6 meses para reduzir do percentual da barra
        $porcentagemBarra = $porcentagemBarra - ($qtdManutencaoMes * 40);

        //conferindo se a barra está com numero negativo
        if($porcentagemBarra < 0){
            $porcentagemBarra = 0 ;
        }

        return view('site.gerenciamento-id', compact('recuperandoDados','porcentagemBarra', 'qtdManutencao', 'qtdManutencaoAno', 'diasUsoEquipamento', 'mesesUsoEquipamento', 'anosUsoEquipamento') );
        
    }

}
