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
        $dadosEmpresaMelhorAvaliadaPreventiva = null;

        if(!empty($empresasQueJaEfetuaramManutençaoPreventiva)){
            $dadosEmpresaMelhorAvaliadaPreventiva['idEmpresa'] = null;
            $dadosEmpresaMelhorAvaliadaPreventiva['media'] = 0;
            $dadosEmpresaMelhorAvaliadaPreventiva['qtdManutencoes'] = 0;
            $dadosEmpresaMelhorAvaliadaPreventiva['indicar'] = false;
            $dadosEmpresaMelhorAvaliadaPreventiva['superiorMedia'] = false;

            foreach($empresasQueJaEfetuaramManutençaoPreventiva as $item){
                $total = 0 ;
                $flagNotaRuim = false ;
                $buscaEmpresaMelhorAvaliadaPreventiva['idEmpresa'] = null;
                $buscaEmpresaMelhorAvaliadaPreventiva['media'] = 0;
                $buscaEmpresaMelhorAvaliadaPreventiva['qtdManutencoes'] = 0;
                foreach($empresasQueJaEfetuaramManutençaoPreventiva as $registro){
                    //Obtendo o total de notas que uma mesma empresa possui
                    if( ( ($registro->fk_pk_empresa) === ($item->fk_pk_empresa) ) ){

                        if(($item->fk_pk_avaliacao) == 1){
                            $flagNotaRuim = true ;
                            $buscaEmpresaMelhorAvaliadaPreventiva['idEmpresa'] = null;
                            $buscaEmpresaMelhorAvaliadaPreventiva['media'] = 0;
                            $buscaEmpresaMelhorAvaliadaPreventiva['qtdManutencoes'] = 0;
                            break;
                        }
                        else
                        {
                            $buscaEmpresaMelhorAvaliadaPreventiva['idEmpresa'] = ($registro->fk_pk_empresa);
                            $total = $total + ($registro->fk_pk_avaliacao);
                            $buscaEmpresaMelhorAvaliadaPreventiva['qtdManutencoes'] = $buscaEmpresaMelhorAvaliadaPreventiva['qtdManutencoes'] + 1;
                        }
                    }
                }

                if( $flagNotaRuim == false){
                    $buscaEmpresaMelhorAvaliadaPreventiva['media'] = $total / $buscaEmpresaMelhorAvaliadaPreventiva['qtdManutencoes'];
                    if( ( ($buscaEmpresaMelhorAvaliadaPreventiva['media']) > ($dadosEmpresaMelhorAvaliadaPreventiva['media']) ) ){
                        $dadosEmpresaMelhorAvaliadaPreventiva['idEmpresa'] = $buscaEmpresaMelhorAvaliadaPreventiva['idEmpresa'] ;
                        $dadosEmpresaMelhorAvaliadaPreventiva['media'] = $buscaEmpresaMelhorAvaliadaPreventiva['media'] ;
                        $dadosEmpresaMelhorAvaliadaPreventiva['qtdManutencoes'] = $buscaEmpresaMelhorAvaliadaPreventiva['qtdManutencoes'] ;
                    }
                }
            }
            // Empresas só serão recomendadas se atingirem a média ou mais
            if( ($dadosEmpresaMelhorAvaliadaPreventiva['idEmpresa'] != null ) && ($dadosEmpresaMelhorAvaliadaPreventiva['media']) >= 2  ){
                $dadosEmpresaMelhorAvaliadaPreventiva['indicar'] = true;
                $idEmpresa = $dadosEmpresaMelhorAvaliadaPreventiva['idEmpresa'];
                $query = DB::select("SELECT nm_empresa, ds_endereco_empresa, ds_email_empresa, ds_telefone_empresa FROM SISCOM_EMPRESA WHERE pk_empresa = $idEmpresa ");
                $dadosEmpresaMelhorAvaliadaPreventiva['nm_empresa']          = $query['0']->nm_empresa;
                $dadosEmpresaMelhorAvaliadaPreventiva['ds_endereco_empresa'] = $query['0']->ds_endereco_empresa;
                $dadosEmpresaMelhorAvaliadaPreventiva['ds_email_empresa']    = $query['0']->ds_email_empresa;
                $dadosEmpresaMelhorAvaliadaPreventiva['ds_telefone_empresa'] = $query['0']->ds_telefone_empresa;

                if( ($dadosEmpresaMelhorAvaliadaPreventiva['media']) > 2  ){
                    $dadosEmpresaMelhorAvaliadaPreventiva['superiorMedia'] = true;
                }
            }
        }
        

        /**tratando manutenções CORRETIVAS */
        //buscando empresas que já efetuaram manutenções
        $qtdEmpresasQueJaEfetuaramManutencaoCorretiva = DB::select("SELECT COUNT(fk_pk_empresa) AS qtdRegistro FROM SISCOM_MANUTENCAO WHERE fk_pk_tipo_manutencao = 2");
        $qtdEmpresasQueJaEfetuaramManutencaoCorretiva = $qtdEmpresasQueJaEfetuaramManutencaoCorretiva['0']->qtdRegistro ; 
        $empresasQueJaEfetuaramManutençaoCorretiva = DB::select("SELECT fk_pk_empresa, fk_pk_avaliacao FROM SISCOM_MANUTENCAO WHERE fk_pk_tipo_manutencao = 2");
        $dadosEmpresaMelhorAvaliadaCorretiva = null;

        if(!empty($empresasQueJaEfetuaramManutençaoCorretiva)){
            $dadosEmpresaMelhorAvaliadaCorretiva['idEmpresa'] = null;
            $dadosEmpresaMelhorAvaliadaCorretiva['media'] = 0;
            $dadosEmpresaMelhorAvaliadaCorretiva['qtdManutencoes'] = 0;
            $dadosEmpresaMelhorAvaliadaCorretiva['indicar'] = false;
            $dadosEmpresaMelhorAvaliadaCorretiva['superiorMedia'] = false;

            foreach($empresasQueJaEfetuaramManutençaoCorretiva as $item){
                $total = 0 ;
                $flagNotaRuim = false ;
                $buscaEmpresaMelhorAvaliadaCorretiva['idEmpresa'] = null;
                $buscaEmpresaMelhorAvaliadaCorretiva['media'] = 0;
                $buscaEmpresaMelhorAvaliadaCorretiva['qtdManutencoes'] = 0;
                
                foreach($empresasQueJaEfetuaramManutençaoCorretiva as $registro){
                    //Obtendo o total de notas que uma mesma empresa possui
                    if( ( ($registro->fk_pk_empresa) === ($item->fk_pk_empresa) ) ){

                        if(($registro->fk_pk_avaliacao) == 1){
                            $flagNotaRuim = true ;
                            $buscaEmpresaMelhorAvaliadaCorretiva['idEmpresa'] = null;
                            $buscaEmpresaMelhorAvaliadaCorretiva['media'] = 0;
                            $buscaEmpresaMelhorAvaliadaCorretiva['qtdManutencoes'] = 0;
                            break;
                        }
                        else
                        {
                            $buscaEmpresaMelhorAvaliadaCorretiva['idEmpresa'] = ($registro->fk_pk_empresa);
                            $total = $total + ($registro->fk_pk_avaliacao);
                            $buscaEmpresaMelhorAvaliadaCorretiva['qtdManutencoes'] = $buscaEmpresaMelhorAvaliadaCorretiva['qtdManutencoes'] + 1;
                        }
                    }
                }

                if( $flagNotaRuim == false){
                    $buscaEmpresaMelhorAvaliadaCorretiva['media'] = $total / $buscaEmpresaMelhorAvaliadaCorretiva['qtdManutencoes'];
                    if( ( ($buscaEmpresaMelhorAvaliadaCorretiva['media']) > ($dadosEmpresaMelhorAvaliadaCorretiva['media']) ) ){
                        $dadosEmpresaMelhorAvaliadaCorretiva['idEmpresa'] = $buscaEmpresaMelhorAvaliadaCorretiva['idEmpresa'] ;
                        $dadosEmpresaMelhorAvaliadaCorretiva['media'] = $buscaEmpresaMelhorAvaliadaCorretiva['media'] ;
                        $dadosEmpresaMelhorAvaliadaCorretiva['qtdManutencoes'] = $buscaEmpresaMelhorAvaliadaCorretiva['qtdManutencoes'] ;
                    }
                }
            }

            // Empresas só serão recomendadas se atingirem a média ou mais
            if( ($dadosEmpresaMelhorAvaliadaCorretiva['idEmpresa'] != null ) && ($dadosEmpresaMelhorAvaliadaCorretiva['media']) >= 2  ){
                $dadosEmpresaMelhorAvaliadaCorretiva['indicar'] = true;
                $idEmpresa = $dadosEmpresaMelhorAvaliadaCorretiva['idEmpresa'];
                $query = DB::select("SELECT nm_empresa, ds_endereco_empresa, ds_email_empresa, ds_telefone_empresa FROM SISCOM_EMPRESA WHERE pk_empresa = $idEmpresa ");
                $dadosEmpresaMelhorAvaliadaCorretiva['nm_empresa']          = $query['0']->nm_empresa;
                $dadosEmpresaMelhorAvaliadaCorretiva['ds_endereco_empresa'] = $query['0']->ds_endereco_empresa;
                $dadosEmpresaMelhorAvaliadaCorretiva['ds_email_empresa']    = $query['0']->ds_email_empresa;
                $dadosEmpresaMelhorAvaliadaCorretiva['ds_telefone_empresa'] = $query['0']->ds_telefone_empresa;
                
                if( ($dadosEmpresaMelhorAvaliadaCorretiva['media']) > 2  ){
                    $dadosEmpresaMelhorAvaliadaCorretiva['superiorMedia'] = true;
                }
            }
        }

        /**tratando manutenções nos equipamentos Eletricos */
        //buscando empresas que já efetuaram manutenções
        $qtdEmpresasQueJaEfetuaramManutencaoEletrico = DB::select("SELECT COUNT(p1.fk_pk_empresa) as qtdRegistro FROM siscom_manutencao p1 INNER JOIN siscom_equipamento p2 ON p2.pk_equipamento = p1.fk_pk_equipamento where p2.fk_pk_tipo_equipamento = 3");
        $qtdEmpresasQueJaEfetuaramManutencaoEletrico = $qtdEmpresasQueJaEfetuaramManutencaoEletrico['0']->qtdRegistro ; 
        $empresasQueJaEfetuaramManutençaoEletrico = DB::select("SELECT p1.fk_pk_empresa, p1.fk_pk_avaliacao FROM siscom_manutencao p1 INNER JOIN siscom_equipamento p2 ON p2.pk_equipamento = p1.fk_pk_equipamento where p2.fk_pk_tipo_equipamento = 3");
        $dadosEmpresaMelhorAvaliadaEletrico = null;

        if(!empty($empresasQueJaEfetuaramManutençaoEletrico)){
            $dadosEmpresaMelhorAvaliadaEletrico['idEmpresa'] = null;
            $dadosEmpresaMelhorAvaliadaEletrico['media'] = 0;
            $dadosEmpresaMelhorAvaliadaEletrico['qtdManutencoes'] = 0;
            $dadosEmpresaMelhorAvaliadaEletrico['indicar'] = false;
            $dadosEmpresaMelhorAvaliadaEletrico['superiorMedia'] = false;
            foreach($empresasQueJaEfetuaramManutençaoEletrico as $item){
                $total = 0 ;
                $flagNotaRuim = false ;
                $buscaEmpresaMelhorAvaliadaEletrico['idEmpresa'] = null;
                $buscaEmpresaMelhorAvaliadaEletrico['media'] = 0;
                $buscaEmpresaMelhorAvaliadaEletrico['qtdManutencoes'] = 0;

                foreach($empresasQueJaEfetuaramManutençaoEletrico as $registro){
                    //Obtendo o total de notas que uma mesma empresa possui
                    if( ( ($registro->fk_pk_empresa) === ($item->fk_pk_empresa) ) ){

                        if(($registro->fk_pk_avaliacao) == 1){
                            $flagNotaRuim = true ;
                            $buscaEmpresaMelhorAvaliadaEletrico['idEmpresa'] = null;
                            $buscaEmpresaMelhorAvaliadaEletrico['media'] = 0;
                            $buscaEmpresaMelhorAvaliadaEletrico['qtdManutencoes'] = 0;
                            break;
                        }
                        else
                        {
                            $buscaEmpresaMelhorAvaliadaEletrico['idEmpresa'] = ($registro->fk_pk_empresa);
                            $total = $total + ($registro->fk_pk_avaliacao);
                            $buscaEmpresaMelhorAvaliadaEletrico['qtdManutencoes'] = $buscaEmpresaMelhorAvaliadaEletrico['qtdManutencoes'] + 1;
                        }
                    }
                }

                if( $flagNotaRuim == false){
                    $buscaEmpresaMelhorAvaliadaEletrico['media'] = $total / $buscaEmpresaMelhorAvaliadaEletrico['qtdManutencoes'];
                    if( ( ($buscaEmpresaMelhorAvaliadaEletrico['media']) > ($dadosEmpresaMelhorAvaliadaEletrico['media']) ) ){
                        $dadosEmpresaMelhorAvaliadaEletrico['idEmpresa'] = $buscaEmpresaMelhorAvaliadaEletrico['idEmpresa'] ;
                        $dadosEmpresaMelhorAvaliadaEletrico['media'] = $buscaEmpresaMelhorAvaliadaEletrico['media'] ;
                        $dadosEmpresaMelhorAvaliadaEletrico['qtdManutencoes'] = $buscaEmpresaMelhorAvaliadaEletrico['qtdManutencoes'] ;
                    }
                }
            }

            // Empresas só serão recomendadas se atingirem a média ou mais
            if( ($dadosEmpresaMelhorAvaliadaEletrico['idEmpresa'] != null ) && ($dadosEmpresaMelhorAvaliadaEletrico['media']) >= 2  ){
                $dadosEmpresaMelhorAvaliadaEletrico['indicar'] = true;
                $idEmpresa = $dadosEmpresaMelhorAvaliadaEletrico['idEmpresa'];
                $query = DB::select("SELECT nm_empresa, ds_endereco_empresa, ds_email_empresa, ds_telefone_empresa FROM SISCOM_EMPRESA WHERE pk_empresa = $idEmpresa ");
                $dadosEmpresaMelhorAvaliadaEletrico['nm_empresa']          = $query['0']->nm_empresa;
                $dadosEmpresaMelhorAvaliadaEletrico['ds_endereco_empresa'] = $query['0']->ds_endereco_empresa;
                $dadosEmpresaMelhorAvaliadaEletrico['ds_email_empresa']    = $query['0']->ds_email_empresa;
                $dadosEmpresaMelhorAvaliadaEletrico['ds_telefone_empresa'] = $query['0']->ds_telefone_empresa;
                
                if(  ($dadosEmpresaMelhorAvaliadaEletrico['media']) > 2  ){
                    $dadosEmpresaMelhorAvaliadaEletrico['superiorMedia'] = true;
                }
            }
        }

        /**tratando manutenções nos equipamentos ELETROELETRONICO */
        //buscando empresas que já efetuaram manutenções
        $qtdEmpresasQueJaEfetuaramManutencaoEletroeletronico = DB::select("SELECT COUNT(p1.fk_pk_empresa) as qtdRegistro FROM siscom_manutencao p1 INNER JOIN siscom_equipamento p2 ON p2.pk_equipamento = p1.fk_pk_equipamento where p2.fk_pk_tipo_equipamento = 1");
        $qtdEmpresasQueJaEfetuaramManutencaoEletroeletronico = $qtdEmpresasQueJaEfetuaramManutencaoEletroeletronico['0']->qtdRegistro ; 
        $empresasQueJaEfetuaramManutençaoEletroeletronico = DB::select("SELECT p1.fk_pk_empresa, p1.fk_pk_avaliacao, p2.pk_equipamento FROM siscom_manutencao p1 INNER JOIN siscom_equipamento p2 ON p2.pk_equipamento = p1.fk_pk_equipamento where p2.fk_pk_tipo_equipamento = 1");
        $dadosEmpresaMelhorAvaliadaEletroeletronico = null;

        if(!empty($empresasQueJaEfetuaramManutençaoEletroeletronico)){
            $dadosEmpresaMelhorAvaliadaEletroeletronico['idEmpresa'] = null;
            $dadosEmpresaMelhorAvaliadaEletroeletronico['media'] = 0;
            $dadosEmpresaMelhorAvaliadaEletroeletronico['qtdManutencoes'] = 0;
            $dadosEmpresaMelhorAvaliadaEletroeletronico['indicar'] = false;
            $dadosEmpresaMelhorAvaliadaEletroeletronico['superiorMedia'] = false;
            foreach($empresasQueJaEfetuaramManutençaoEletroeletronico as $item){
                $total = 0 ;
                $flagNotaRuim = false ;
                $buscaEmpresaMelhorAvaliadaEletroeletronico['idEmpresa'] = null;
                $buscaEmpresaMelhorAvaliadaEletroeletronico['media'] = 0;
                $buscaEmpresaMelhorAvaliadaEletroeletronico['qtdManutencoes'] = 0;
                
                foreach($empresasQueJaEfetuaramManutençaoEletroeletronico as $registro){
                    //Obtendo o total de notas que uma mesma empresa possui
                    if( ( ($registro->fk_pk_empresa) === ($item->fk_pk_empresa) ) ){

                        if(($registro->fk_pk_avaliacao) == 1){
                            $flagNotaRuim = true ;
                            $buscaEmpresaMelhorAvaliadaEletroeletronico['idEmpresa'] = null;
                            $buscaEmpresaMelhorAvaliadaEletroeletronico['media'] = 0;
                            $buscaEmpresaMelhorAvaliadaEletroeletronico['qtdManutencoes'] = 0;
                            break;
                        }
                        else
                        {
                            $buscaEmpresaMelhorAvaliadaEletroeletronico['idEmpresa'] = ($registro->fk_pk_empresa);
                            $total = $total + ($registro->fk_pk_avaliacao);
                            $buscaEmpresaMelhorAvaliadaEletroeletronico['qtdManutencoes'] = $buscaEmpresaMelhorAvaliadaEletroeletronico['qtdManutencoes'] + 1;
                        }
                    }
                }

                if( $flagNotaRuim == false){
                    $buscaEmpresaMelhorAvaliadaEletroeletronico['media'] = $total / $buscaEmpresaMelhorAvaliadaEletroeletronico['qtdManutencoes'];
                    if( ( ($buscaEmpresaMelhorAvaliadaEletroeletronico['media']) > ($dadosEmpresaMelhorAvaliadaEletroeletronico['media']) ) ){
                        $dadosEmpresaMelhorAvaliadaEletroeletronico['idEmpresa'] = $buscaEmpresaMelhorAvaliadaEletroeletronico['idEmpresa'] ;
                        $dadosEmpresaMelhorAvaliadaEletroeletronico['media'] = $buscaEmpresaMelhorAvaliadaEletroeletronico['media'] ;
                        $dadosEmpresaMelhorAvaliadaEletroeletronico['qtdManutencoes'] = $buscaEmpresaMelhorAvaliadaEletroeletronico['qtdManutencoes'] ;
                    }
                }
                
            }

            // Empresas só serão recomendadas se atingirem a média ou mais
            if( ($dadosEmpresaMelhorAvaliadaEletroeletronico['idEmpresa'] != null ) && ($dadosEmpresaMelhorAvaliadaEletroeletronico['media']) >= 2  ){
                $dadosEmpresaMelhorAvaliadaEletroeletronico['indicar'] = true;
                $idEmpresa = $dadosEmpresaMelhorAvaliadaEletroeletronico['idEmpresa'];
                $query = DB::select("SELECT nm_empresa, ds_endereco_empresa, ds_email_empresa, ds_telefone_empresa FROM SISCOM_EMPRESA WHERE pk_empresa = $idEmpresa ");
                $dadosEmpresaMelhorAvaliadaEletroeletronico['nm_empresa']          = $query['0']->nm_empresa;
                $dadosEmpresaMelhorAvaliadaEletroeletronico['ds_endereco_empresa'] = $query['0']->ds_endereco_empresa;
                $dadosEmpresaMelhorAvaliadaEletroeletronico['ds_email_empresa']    = $query['0']->ds_email_empresa;
                $dadosEmpresaMelhorAvaliadaEletroeletronico['ds_telefone_empresa'] = $query['0']->ds_telefone_empresa;
                
                if( ($dadosEmpresaMelhorAvaliadaEletroeletronico['media']) > 2  ){
                    $dadosEmpresaMelhorAvaliadaEletroeletronico['superiorMedia'] = true;
                }
            }
        }

        /**tratando manutenções nos equipamentos ELETRONICO */
        //buscando empresas que já efetuaram manutenções
        $qtdEmpresasQueJaEfetuaramManutencaoEletronico = DB::select("SELECT COUNT(p1.fk_pk_empresa) as qtdRegistro FROM siscom_manutencao p1 INNER JOIN siscom_equipamento p2 ON p2.pk_equipamento = p1.fk_pk_equipamento where p2.fk_pk_tipo_equipamento = 2");
        $qtdEmpresasQueJaEfetuaramManutencaoEletronico = $qtdEmpresasQueJaEfetuaramManutencaoEletronico['0']->qtdRegistro ; 
        $empresasQueJaEfetuaramManutençaoEletronico = DB::select("SELECT p2.pk_equipamento, p1.pk_manutencao, p1.fk_pk_empresa, p1.fk_pk_avaliacao FROM siscom_manutencao p1 INNER JOIN siscom_equipamento p2 ON p2.pk_equipamento = p1.fk_pk_equipamento where p2.fk_pk_tipo_equipamento = 2");
        $dadosEmpresaMelhorAvaliadaEletronico = null;
        //dd($empresasQueJaEfetuaramManutençaoEletronico);
        if(!empty($empresasQueJaEfetuaramManutençaoEletronico)){
            $dadosEmpresaMelhorAvaliadaEletronico['idEmpresa'] = null;
            $dadosEmpresaMelhorAvaliadaEletronico['media'] = 0;
            $dadosEmpresaMelhorAvaliadaEletronico['qtdManutencoes'] = 0;
            $dadosEmpresaMelhorAvaliadaEletronico['indicar'] = false;
            $dadosEmpresaMelhorAvaliadaEletronico['superiorMedia'] = false;

            foreach($empresasQueJaEfetuaramManutençaoEletronico as $item){
                $total = 0 ;
                $flagNotaRuim = false ;
                $buscaEmpresaMelhorAvaliadaEletronico['idEmpresa'] = null;
                $buscaEmpresaMelhorAvaliadaEletronico['media'] = 0;
                $buscaEmpresaMelhorAvaliadaEletronico['qtdManutencoes'] = 0;
                
                foreach($empresasQueJaEfetuaramManutençaoEletronico as $registro){
                    
                    //Obtendo o total de notas que uma mesma empresa possui
                    if( ( ($registro->fk_pk_empresa) === ($item->fk_pk_empresa) ) ){
                        if(($registro->fk_pk_avaliacao) == 1){
                            $flagNotaRuim = true ;
                            $buscaEmpresaMelhorAvaliadaEletronico['idEmpresa'] = null;
                            $buscaEmpresaMelhorAvaliadaEletronico['media'] = 0;
                            $buscaEmpresaMelhorAvaliadaEletronico['qtdManutencoes'] = 0;
                            break;
                        }
                        else
                        {
                            //var_dump($registro);
                            $buscaEmpresaMelhorAvaliadaEletronico['idEmpresa'] = ($registro->fk_pk_empresa);
                            $total = $total + ($registro->fk_pk_avaliacao);
                            $buscaEmpresaMelhorAvaliadaEletronico['qtdManutencoes'] = $buscaEmpresaMelhorAvaliadaEletronico['qtdManutencoes'] + 1;
                        }
                    }
                }

                if( $flagNotaRuim == false){
                    $buscaEmpresaMelhorAvaliadaEletronico['media'] = $total / $buscaEmpresaMelhorAvaliadaEletronico['qtdManutencoes'];
                    if( ( ($buscaEmpresaMelhorAvaliadaEletronico['media']) > ($dadosEmpresaMelhorAvaliadaEletronico['media']) ) ){
                        $dadosEmpresaMelhorAvaliadaEletronico['idEmpresa'] = $buscaEmpresaMelhorAvaliadaEletronico['idEmpresa'] ;
                        $dadosEmpresaMelhorAvaliadaEletronico['media'] = $buscaEmpresaMelhorAvaliadaEletronico['media'] ;
                        $dadosEmpresaMelhorAvaliadaEletronico['qtdManutencoes'] = $buscaEmpresaMelhorAvaliadaEletronico['qtdManutencoes'] ;
                    }
                }
            }
            // Empresas só serão recomendadas se atingirem a média ou mais
            if( ($dadosEmpresaMelhorAvaliadaEletronico['idEmpresa'] != null ) && ($dadosEmpresaMelhorAvaliadaEletronico['media'])  >= 2  ){
                $dadosEmpresaMelhorAvaliadaEletronico['indicar'] = true;
                $idEmpresa = $dadosEmpresaMelhorAvaliadaEletronico['idEmpresa'];
                $query = DB::select("SELECT nm_empresa, ds_endereco_empresa, ds_email_empresa, ds_telefone_empresa FROM SISCOM_EMPRESA WHERE pk_empresa = $idEmpresa ");
                $dadosEmpresaMelhorAvaliadaEletronico['nm_empresa']          = $query['0']->nm_empresa;
                $dadosEmpresaMelhorAvaliadaEletronico['ds_endereco_empresa'] = $query['0']->ds_endereco_empresa;
                $dadosEmpresaMelhorAvaliadaEletronico['ds_email_empresa']    = $query['0']->ds_email_empresa;
                $dadosEmpresaMelhorAvaliadaEletronico['ds_telefone_empresa'] = $query['0']->ds_telefone_empresa;
                
                if( ($dadosEmpresaMelhorAvaliadaEletronico['media']) > 2  ){
                    $dadosEmpresaMelhorAvaliadaEletronico['superiorMedia'] = true;
                }
            }   
        }

        /**tratando manutenções nos equipamentos ELETRODOMESTICO */
        //buscando empresas que já efetuaram manutenções
        $qtdEmpresasQueJaEfetuaramManutencaoEletrodomestico = DB::select("SELECT COUNT(p1.fk_pk_empresa) as qtdRegistro FROM siscom_manutencao p1 INNER JOIN siscom_equipamento p2 ON p2.pk_equipamento = p1.fk_pk_equipamento where p2.fk_pk_tipo_equipamento = 4");
        $qtdEmpresasQueJaEfetuaramManutencaoEletrodomestico = $qtdEmpresasQueJaEfetuaramManutencaoEletrodomestico['0']->qtdRegistro ; 
        $empresasQueJaEfetuaramManutençaoEletrodomestico = DB::select("SELECT p1.fk_pk_empresa, p1.fk_pk_avaliacao FROM siscom_manutencao p1 INNER JOIN siscom_equipamento p2 ON p2.pk_equipamento = p1.fk_pk_equipamento where p2.fk_pk_tipo_equipamento = 4");
        $dadosEmpresaMelhorAvaliadaEletrodomestico = null;

        if(!empty($empresasQueJaEfetuaramManutençaoEletrodomestico)){
            $dadosEmpresaMelhorAvaliadaEletrodomestico['idEmpresa'] = null;
            $dadosEmpresaMelhorAvaliadaEletrodomestico['media'] = 0;
            $dadosEmpresaMelhorAvaliadaEletrodomestico['qtdManutencoes'] = 0;
            $dadosEmpresaMelhorAvaliadaEletrodomestico['indicar'] = false;
            $dadosEmpresaMelhorAvaliadaEletrodomestico['superiorMedia'] = false;
            foreach($empresasQueJaEfetuaramManutençaoEletrodomestico as $item){
                $total = 0 ;
                $flagNotaRuim = false ;
                $buscaEmpresaMelhorAvaliadaEletrodomestico['idEmpresa'] = null;
                $buscaEmpresaMelhorAvaliadaEletrodomestico['media'] = 0;
                $buscaEmpresaMelhorAvaliadaEletrodomestico['qtdManutencoes'] = 0;
                
                foreach($empresasQueJaEfetuaramManutençaoEletrodomestico as $registro){
                    //Obtendo o total de notas que uma mesma empresa possui
                    if( ( ($registro->fk_pk_empresa) === ($item->fk_pk_empresa) ) ){

                        if(($registro->fk_pk_avaliacao) == 1){
                            $flagNotaRuim = true ;
                            $buscaEmpresaMelhorAvaliadaEletrodomestico['idEmpresa'] = null;
                            $buscaEmpresaMelhorAvaliadaEletrodomestico['media'] = 0;
                            $buscaEmpresaMelhorAvaliadaEletrodomestico['qtdManutencoes'] = 0;
                            break;
                        }
                        else
                        {
                            $buscaEmpresaMelhorAvaliadaEletrodomestico['idEmpresa'] = ($registro->fk_pk_empresa);
                            $total = $total + ($registro->fk_pk_avaliacao);
                            $buscaEmpresaMelhorAvaliadaEletrodomestico['qtdManutencoes'] = $buscaEmpresaMelhorAvaliadaEletrodomestico['qtdManutencoes'] + 1;
                        }
                    }
                }

                if( $flagNotaRuim == false){
                    $buscaEmpresaMelhorAvaliadaEletrodomestico['media'] = $total / $buscaEmpresaMelhorAvaliadaEletrodomestico['qtdManutencoes'];
                    if( ( ($buscaEmpresaMelhorAvaliadaEletrodomestico['media']) > ($dadosEmpresaMelhorAvaliadaEletrodomestico['media']) ) ){
                        $dadosEmpresaMelhorAvaliadaEletrodomestico['idEmpresa'] = $buscaEmpresaMelhorAvaliadaEletrodomestico['idEmpresa'] ;
                        $dadosEmpresaMelhorAvaliadaEletrodomestico['media'] = $buscaEmpresaMelhorAvaliadaEletrodomestico['media'] ;
                        $dadosEmpresaMelhorAvaliadaEletrodomestico['qtdManutencoes'] = $buscaEmpresaMelhorAvaliadaEletrodomestico['qtdManutencoes'] ;
                    }
                }
            }
            // Empresas só serão recomendadas se atingirem a média ou mais
            if( ($dadosEmpresaMelhorAvaliadaEletrodomestico['idEmpresa'] != null ) && ($dadosEmpresaMelhorAvaliadaEletrodomestico['media']) >= 2  ){
                $dadosEmpresaMelhorAvaliadaEletrodomestico['indicar'] = true;
                $idEmpresa = $dadosEmpresaMelhorAvaliadaEletrodomestico['idEmpresa'];
                $query = DB::select("SELECT nm_empresa, ds_endereco_empresa, ds_email_empresa, ds_telefone_empresa FROM SISCOM_EMPRESA WHERE pk_empresa = $idEmpresa ");
                $dadosEmpresaMelhorAvaliadaEletrodomestico['nm_empresa']          = $query['0']->nm_empresa;
                $dadosEmpresaMelhorAvaliadaEletrodomestico['ds_endereco_empresa'] = $query['0']->ds_endereco_empresa;
                $dadosEmpresaMelhorAvaliadaEletrodomestico['ds_email_empresa']    = $query['0']->ds_email_empresa;
                $dadosEmpresaMelhorAvaliadaEletrodomestico['ds_telefone_empresa'] = $query['0']->ds_telefone_empresa;
                
                if(  ($dadosEmpresaMelhorAvaliadaEletrodomestico['media']) > 2  ){
                    $dadosEmpresaMelhorAvaliadaEletrodomestico['superiorMedia'] = true;
                }
            }
        }

        //dd($dadosEmpresaMelhorAvaliadaCorretiva, $dadosEmpresaMelhorAvaliadaEletrico, $dadosEmpresaMelhorAvaliadaEletrodomestico, $dadosEmpresaMelhorAvaliadaEletroeletronico, $dadosEmpresaMelhorAvaliadaEletronico, $dadosEmpresaMelhorAvaliadaPreventiva);

        return view('site.indicar-empresa', compact('dadosEmpresaMelhorAvaliadaCorretiva', 'dadosEmpresaMelhorAvaliadaEletrico', 'dadosEmpresaMelhorAvaliadaEletrodomestico', 'dadosEmpresaMelhorAvaliadaEletroeletronico', 'dadosEmpresaMelhorAvaliadaEletronico', 'dadosEmpresaMelhorAvaliadaPreventiva') );
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
