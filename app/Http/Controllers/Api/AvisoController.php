<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\ApiControllerTrait;

class AvisoController extends Controller
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
     * <b>index</b> Método responsável em receber a requisição do tipo GET e encaminhar a mesma para o metodo index da ApiControllerTrait
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(){

        //obtendo os dados dos equipamentos que não receberam manutenções nos ultimos 1 ANO OBS: Só serão avisados os equipamentos que já tenham 1 ano ou mais de uso
        $obterEquipamentosComUmAnoDeUso = DB::select("SELECT pk_equipamento FROM siscom_equipamento WHERE TIMESTAMPDIFF(YEAR,dt_compra_equipamento, now()) >=1");
        //dd($obterEquipamentosComUmAnoDeUso);

        if(!empty($obterEquipamentosComUmAnoDeUso)){
            foreach($obterEquipamentosComUmAnoDeUso as $item){
                //obtendo os dados dos equipamentos que não receberam manutenções nos ultimos 2 ANOS OBS: Só serão avisados os equipamentos que já tenham 1 ano ou mais de uso
                $obterEquipamentoSeisMesesSemManutencao = DB::select("SELECT p2.pk_manutencao, p1.pk_equipamento, p1.nm_equipamento, p1.dt_compra_equipamento FROM siscom_equipamento p1 INNER JOIN siscom_manutencao p2 ON p2.fk_pk_equipamento = p1.pk_equipamento WHERE p2.fk_pk_equipamento = $item->pk_equipamento AND p1.pk_equipamento = $item->pk_equipamento AND TIMESTAMPDIFF(YEAR,p1.dt_compra_equipamento, p2.dt_manutencao) >= 1 AND TIMESTAMPDIFF(MONTH,p2.dt_manutencao, NOW()) <= 6");
                $obterEquipamentoUmAnoSemManutencao = DB::select("SELECT p2.pk_manutencao, p1.pk_equipamento, p1.nm_equipamento, p1.dt_compra_equipamento FROM siscom_equipamento p1 INNER JOIN siscom_manutencao p2 ON p2.fk_pk_equipamento = p1.pk_equipamento WHERE p2.fk_pk_equipamento = $item->pk_equipamento AND p1.pk_equipamento = $item->pk_equipamento AND TIMESTAMPDIFF(YEAR,p1.dt_compra_equipamento, p2.dt_manutencao) >= 1 AND TIMESTAMPDIFF(YEAR,p2.dt_manutencao, NOW()) <= 1");
                $obterEquipamentoDoisAnoSemManutencao = DB::select("SELECT p2.pk_manutencao, p1.pk_equipamento, p1.nm_equipamento, p1.dt_compra_equipamento FROM siscom_equipamento p1 INNER JOIN siscom_manutencao p2 ON p2.fk_pk_equipamento = p1.pk_equipamento WHERE p2.fk_pk_equipamento = $item->pk_equipamento AND p1.pk_equipamento = $item->pk_equipamento AND TIMESTAMPDIFF(YEAR,p1.dt_compra_equipamento, p2.dt_manutencao) >= 1 AND TIMESTAMPDIFF(YEAR,p2.dt_manutencao, NOW()) <= 2");
                //dd($obterEquipamentoSeisMesesSemManutencao['0']->nm_equipamento, $obterEquipamentoUmAnoSemManutencao, $obterEquipamentoDoisAnoSemManutencao);
                dd($obterEquipamentoSeisMesesSemManutencao, $obterEquipamentoUmAnoSemManutencao, $obterEquipamentoDoisAnoSemManutencao);
                /*dd($obterEquipamentoDoisAnosSemManutencao);
                foreach($obterEquipamentoDoisAnosSemManutencao as $registro){
                    $obtendo [] = ['pk_equipamento' => $registro->pk_equipamento,];
                }
                dd($obtendo);
                Removendo valores duplicados no array
                $teste = array_unique($obtendo);*/
                if(!empty($obterEquipamentoSeisMesesSemManutencao))
                {
                    $equipamentoSeisMesesSemManutencao [] = [
                        'pk_equipamento'        => $obterEquipamentoSeisMesesSemManutencao['0']->pk_equipamento,
                        'nm_equipamento'        => $obterEquipamentoSeisMesesSemManutencao['0']->nm_equipamento,
                        'dt_compra_equipamento' => $obterEquipamentoSeisMesesSemManutencao['0']->dt_compra_equipamento,
                    ];
                }else if(!empty($obterEquipamentoUmAnoSemManutencao)){
                    $equipamentoUmAnoSemManutencao [] = [
                        'pk_equipamento'        => $obterEquipamentoUmAnoSemManutencao['0']->pk_equipamento,
                        'nm_equipamento'        => $obterEquipamentoUmAnoSemManutencao['0']->nm_equipamento,
                        'dt_compra_equipamento' => $obterEquipamentoUmAnoSemManutencao['0']->dt_compra_equipamento,
                    ];
                    
                }else if(!empty($obterEquipamentoDoisAnosSemManutencao)){
                    $equipamentoDoisAnosSemManutencao [] = [
                        'pk_equipamento'        => $obterEquipamentoDoisAnosSemManutencao['0']->pk_equipamento,
                        'nm_equipamento'        => $obterEquipamentoDoisAnosSemManutencao['0']->nm_equipamento,
                        'dt_compra_equipamento' => $obterEquipamentoDoisAnosSemManutencao['0']->dt_compra_equipamento,
                    ];
                    
                }
            }
            dd($obterEquipamentoUmAnoSemManutencao);
            dd($equipamentoUmAnoSemManutencao);

        }
        return view('site.avisos', compact('equipamentoUmAnoSemManutencao', 'equipamentoDoisAnosSemManutencao', 'equipamentoSeisMesesSemManutencao'));

    }
}
