<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiControllerTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Empresa;

class IndicarEmpresaController extends Controller
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
    public function __construct(Empresa $model)
    {
        $this->model = $model;
    }
    /**
     * <b>index</b> Método responsável em receber a requisição do tipo GET e encaminhar a mesma para o metodo index da ApiControllerTrait
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(){
        /**tratando manutenções PREVENTIVAS */
        //buscando empresas que já efetuaram manutenções
        $qtdEmpresasQueJaEfetuaramManutencaoPreventiva = DB::select("SELECT COUNT(fk_pk_empresa) AS qtdRegistro FROM SISCOM_MANUTENCAO WHERE fk_pk_tipo_manutencao = 1");
        $qtdEmpresasQueJaEfetuaramManutencaoPreventiva = $qtdEmpresasQueJaEfetuaramManutencaoPreventiva['0']->qtdRegistro ; 
        $empresasQueJaEfetuaramManutençaoPreventiva = DB::select("SELECT fk_pk_empresa, fk_pk_avaliacao FROM SISCOM_MANUTENCAO WHERE fk_pk_tipo_manutencao = 1");
        //dd($empresasQueJaEfetuaramManutençao);

        if(!empty($empresasQueJaEfetuaramManutençaoPreventiva)){
            $dadosEmpresaMelhorAvaliadaPreventiva['idEmpresa'] = null;
            $dadosEmpresaMelhorAvaliadaPreventiva['total'] = 0;
            foreach($empresasQueJaEfetuaramManutençaoPreventiva as $item){
                var_dump("id de referencia : $item->fk_pk_empresa");
                $cont = 0 ;
                $buscaEmpresaMelhorAvaliadaPreventiva['idEmpresa'] = null;
                $buscaEmpresaMelhorAvaliadaPreventiva['total'] = 0;
                do{
                    //Obtendo o total de notas que uma mesma empresa possui
                    if(($empresasQueJaEfetuaramManutençaoPreventiva["$cont"]->fk_pk_empresa) === ($item->fk_pk_empresa)){
                        $buscaEmpresaMelhorAvaliadaPreventiva['idEmpresa'] = ($empresasQueJaEfetuaramManutençaoPreventiva["$cont"]->fk_pk_empresa);
                        $buscaEmpresaMelhorAvaliadaPreventiva['total']     = ($buscaEmpresaMelhorAvaliadaPreventiva['total']) + ($empresasQueJaEfetuaramManutençaoPreventiva["$cont"]->fk_pk_avaliacao);
                    }
                    $cont ++ ;
                }while($cont <= ($qtdEmpresasQueJaEfetuaramManutencaoPreventiva -1));
                //var_dump("TOTAL: $totalAvaliacao") ;
                //dd($dadosEmpresaMelhorAvaliada['total']);
                //dd('total', $totalAvaliacao);
                if(($buscaEmpresaMelhorAvaliadaPreventiva['total']) > $dadosEmpresaMelhorAvaliadaPreventiva['total']){
                    $dadosEmpresaMelhorAvaliadaPreventiva['idEmpresa'] = $buscaEmpresaMelhorAvaliadaPreventiva['idEmpresa'] ;
                    $dadosEmpresaMelhorAvaliadaPreventiva['total'] = $buscaEmpresaMelhorAvaliadaPreventiva['total'] ;
                }
                //dd($dadosEmpresaMelhorAvaliadaPreventiva);
            }
        }

        /**tratando manutenções CORRETIVAS */
        //buscando empresas que já efetuaram manutenções
        $qtdEmpresasQueJaEfetuaramManutencaoCorretiva = DB::select("SELECT COUNT(fk_pk_empresa) AS qtdRegistro FROM SISCOM_MANUTENCAO WHERE fk_pk_tipo_manutencao = 2");
        $qtdEmpresasQueJaEfetuaramManutencaoCorretiva = $qtdEmpresasQueJaEfetuaramManutencaoCorretiva['0']->qtdRegistro ; 
        $empresasQueJaEfetuaramManutençaoCorretiva = DB::select("SELECT fk_pk_empresa, fk_pk_avaliacao FROM SISCOM_MANUTENCAO WHERE fk_pk_tipo_manutencao = 2");
        //dd($empresasQueJaEfetuaramManutençao);

        if(!empty($empresasQueJaEfetuaramManutençaoCorretiva)){
            $dadosEmpresaMelhorAvaliadaCorretiva['idEmpresa'] = null;
            $dadosEmpresaMelhorAvaliadaCorretiva['total'] = 0;
            foreach($empresasQueJaEfetuaramManutençaoCorretiva as $item){
                var_dump("id de referencia : $item->fk_pk_empresa");
                $cont = 0 ;
                $buscaEmpresaMelhorAvaliadaCorretiva['idEmpresa'] = null;
                $buscaEmpresaMelhorAvaliadaCorretiva['total'] = 0;
                do{
                    //Obtendo o total de notas que uma mesma empresa possui
                    if(($empresasQueJaEfetuaramManutençaoCorretiva["$cont"]->fk_pk_empresa) === ($item->fk_pk_empresa)){
                        $buscaEmpresaMelhorAvaliadaCorretiva['idEmpresa'] = ($empresasQueJaEfetuaramManutençaoCorretiva["$cont"]->fk_pk_empresa);
                        $buscaEmpresaMelhorAvaliadaCorretiva['total']     = ($buscaEmpresaMelhorAvaliadaCorretiva['total']) + ($empresasQueJaEfetuaramManutençaoCorretiva["$cont"]->fk_pk_avaliacao);
                    }
                    $cont ++ ;
                }while($cont <= ($qtdEmpresasQueJaEfetuaramManutencaoCorretiva -1));
                //var_dump("TOTAL: $totalAvaliacao") ;
                //dd($dadosEmpresaMelhorAvaliada['total']);
                //dd('total', $totalAvaliacao);
                if(($buscaEmpresaMelhorAvaliadaCorretiva['total']) > $dadosEmpresaMelhorAvaliadaCorretiva['total']){
                    $dadosEmpresaMelhorAvaliadaCorretiva['idEmpresa'] = $buscaEmpresaMelhorAvaliadaCorretiva['idEmpresa'] ;
                    $dadosEmpresaMelhorAvaliadaCorretiva['total'] = $buscaEmpresaMelhorAvaliadaCorretiva['total'] ;
                }
                //dd($dadosEmpresaMelhorAvaliadaCorretiva);
            }
        }

        /**tratando manutenções nos equipamentos Eletricos */
        //buscando empresas que já efetuaram manutenções
        $qtdEmpresasQueJaEfetuaramManutencaoEletrico = DB::select("SELECT COUNT(p1.fk_pk_empresa) as qtdRegistro FROM siscom_manutencao p1 INNER JOIN siscom_equipamento p2 ON p2.pk_equipamento = p1.fk_pk_equipamento where p2.fk_pk_tipo_equipamento = 3");
        $qtdEmpresasQueJaEfetuaramManutencaoEletrico = $qtdEmpresasQueJaEfetuaramManutencaoEletrico['0']->qtdRegistro ; 
        //dd($qtdEmpresasQueJaEfetuaramManutencaoEletrico);
        $empresasQueJaEfetuaramManutençaoEletrico = DB::select("SELECT p1.fk_pk_empresa, p1.fk_pk_avaliacao FROM siscom_manutencao p1 INNER JOIN siscom_equipamento p2 ON p2.pk_equipamento = p1.fk_pk_equipamento where p2.fk_pk_tipo_equipamento = 3");
        //dd($empresasQueJaEfetuaramManutençaoEletrico);

        if(!empty($empresasQueJaEfetuaramManutençaoEletrico)){
            $dadosEmpresaMelhorAvaliadaEletrico['idEmpresa'] = null;
            $dadosEmpresaMelhorAvaliadaEletrico['total'] = 0;
            foreach($empresasQueJaEfetuaramManutençaoEletrico as $item){
                var_dump("id de referencia : $item->fk_pk_empresa");
                $cont = 0 ;
                $buscaEmpresaMelhorAvaliadaEletrico['idEmpresa'] = null;
                $buscaEmpresaMelhorAvaliadaEletrico['total'] = 0;
                do{
                    //Obtendo o total de notas que uma mesma empresa possui
                    if(($empresasQueJaEfetuaramManutençaoEletrico["$cont"]->fk_pk_empresa) === ($item->fk_pk_empresa)){
                        $buscaEmpresaMelhorAvaliadaEletrico['idEmpresa'] = ($empresasQueJaEfetuaramManutençaoEletrico["$cont"]->fk_pk_empresa);
                        $buscaEmpresaMelhorAvaliadaEletrico['total']     = ($buscaEmpresaMelhorAvaliadaEletrico['total']) + ($empresasQueJaEfetuaramManutençaoEletrico["$cont"]->fk_pk_avaliacao);
                    }
                    $cont ++ ;
                }while($cont <= ($qtdEmpresasQueJaEfetuaramManutencaoEletrico -1));
                //var_dump("TOTAL: $totalAvaliacao") ;
                //dd($dadosEmpresaMelhorAvaliada['total']);
                //dd('total', $totalAvaliacao);
                if(($buscaEmpresaMelhorAvaliadaEletrico['total']) > $dadosEmpresaMelhorAvaliadaEletrico['total']){
                    $dadosEmpresaMelhorAvaliadaEletrico['idEmpresa'] = $buscaEmpresaMelhorAvaliadaEletrico['idEmpresa'] ;
                    $dadosEmpresaMelhorAvaliadaEletrico['total'] = $buscaEmpresaMelhorAvaliadaEletrico['total'] ;
                }
                dd($dadosEmpresaMelhorAvaliadaEletrico);
            }
        }
        
        dd($empresasQueJaEfetuaramManutençao,'empresa com melhor avaliacao', $empresaMelhorAvaliada);
        //buscando empresas com melhor qualificação, pelo tipo de manutenção PREVENTIVA
        $obterEmpresasPorTipo = DB::select("SELECT fk_pk_empresa,fk_pk_avaliacao FROM SISCOM_MANUTENCAO WHERE fk_pk_tipo_manutencao = 1 AND fk_pk_avaliacao > 0 AND fk_pk_avaliacao < 4  ");
        //dd($obterEmpresasPorTipo);
        foreach($obterEmpresasPorTipo as $item){
            if($item->fk_pk_avaliacao == 3){
                $flag = true;
                $empresaIndicada = DB::select("SELECT nm_empresa,ds_endereco_empresa,ds_telefone_empresa, ds_email_empresa, ds_cnpj_empresa FROM SISCOM_EMPRESA WHERE PK_EMPRESA = $item->fk_pk_empresa  ");
            }
        }
        if($flag != true){
            if($item->fk_pk_avaliacao == 2){
                $flag = true;
                $empresaIndicada = DB::select("SELECT nm_empresa,ds_endereco_empresa,ds_telefone_empresa, ds_email_empresa, ds_cnpj_empresa FROM SISCOM_EMPRESA WHERE PK_EMPRESA = $item->fk_pk_empresa  ");
            }
        }
        //$recuperandoDados = $this->model->get();
        //dd($recuperandoDados);
        return view('site.indicar-empresa', compact('recuperandoDados') );
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
