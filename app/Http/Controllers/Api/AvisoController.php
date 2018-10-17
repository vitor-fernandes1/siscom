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
                //obtendo o tempo entre as manutenções e o dia atual
                $obterInfoEquipamentoManutencao = DB::select("SELECT p1.pk_equipamento, p2.pk_manutencao, p1.nm_equipamento, p1.dt_compra_equipamento, TIMESTAMPDIFF(DAY, p2.dt_manutencao, NOW()) as dias FROM siscom_equipamento p1 INNER JOIN siscom_manutencao p2 ON p2.fk_pk_equipamento = p1.pk_equipamento where p1.pk_equipamento = $item->pk_equipamento");
                //dd($obterInfoEquipamentoManutencao);
                $cont = 0 ;
                //obter ultima manutencao
                if(!empty($obterInfoEquipamentoManutencao))
                {
                    foreach($obterInfoEquipamentoManutencao as $registro){
                        if($cont == 0){
                            $obterDataUltimaManutencao = [ 'pk_manutencao' => $registro->pk_manutencao, 'dias' => $registro->dias ] ;
                        }
                        else if($registro->dias < $obterDataUltimaManutencao['dias']){
                            $obterDataUltimaManutencao = [ 'pk_manutencao' => $registro->pk_manutencao, 'dias' => $registro->dias ] ;
                        }
                        $cont++;
                    }
                    //var_dump($obterDataUltimaManutencao['dias']);
                    //Verificando por equipamentos que não obtiveram manutenções nos ultimos 2 anos
                    if($obterDataUltimaManutencao['dias'] > 730){
                        $equipamentoDoisAnosSemManutencao [] = [
                            'pk_equipamento'        => $obterInfoEquipamentoManutencao['0']->pk_equipamento,
                            'nm_equipamento'        => $obterInfoEquipamentoManutencao['0']->nm_equipamento,
                            'dt_compra_equipamento' => $obterInfoEquipamentoManutencao['0']->dt_compra_equipamento,
                        ];
                    }
                    //Verificando por equipamentos que não obtiveram manutenções nos ultimos 1 ano
                    else if($obterDataUltimaManutencao['dias'] > 365){
                        $equipamentoUmAnoSemManutencao [] = [
                            'pk_equipamento'        => $obterInfoEquipamentoManutencao['0']->pk_equipamento,
                            'nm_equipamento'        => $obterInfoEquipamentoManutencao['0']->nm_equipamento,
                            'dt_compra_equipamento' => $obterInfoEquipamentoManutencao['0']->dt_compra_equipamento,
                        ];
                    }
                    //Verificando por equipamentos que não obtiveram manutenções nos ultimos 6 meses
                    else if($obterDataUltimaManutencao['dias'] > 180){
                        $equipamentoSeisMesesSemManutencao [] = [
                            'pk_equipamento'        => $obterInfoEquipamentoManutencao['0']->pk_equipamento,
                            'nm_equipamento'        => $obterInfoEquipamentoManutencao['0']->nm_equipamento,
                            'dt_compra_equipamento' => $obterInfoEquipamentoManutencao['0']->dt_compra_equipamento,
                        ];
                    }
                    
                    /*
                    if(isset($equipamentoDoisAnosSemManutencao)){
                        var_dump('2',$equipamentoDoisAnosSemManutencao);
                    }else if(isset($equipamentoUmAnoSemManutencao)){
                        var_dump('1',$equipamentoUmAnoSemManutencao);
                    }else if(isset($equipamentoSeisMesesSemManutencao)){
                        var_dump('6',$equipamentoSeisMesesSemManutencao);
                    }*/

                }else{
                    $obterEquipamentoSemManutencao = DB::select("SELECT pk_equipamento, nm_equipamento, dt_compra_equipamento FROM siscom_equipamento WHERE pk_equipamento = $item->pk_equipamento ");
                    $equipamentoSemManutencao [] = [
                        'pk_equipamento'        => $obterEquipamentoSemManutencao['0']->pk_equipamento,
                        'nm_equipamento'        => $obterEquipamentoSemManutencao['0']->nm_equipamento,
                        'dt_compra_equipamento' => $obterEquipamentoSemManutencao['0']->dt_compra_equipamento,
                    ];
                }
            }
            

        }

        //Verificando as variaveis que obtiveram dados, para setar como null as que não obtiveram, para posterior validação no front-end
        if(!isset($equipamentoDoisAnosSemManutencao)){
            $equipamentoDoisAnosSemManutencao = null;
        }
        if(!isset($equipamentoUmAnoSemManutencao)){
            $equipamentoUmAnoSemManutencao = null;
        }
        if(!isset($equipamentoSeisMesesSemManutencao)){
            $equipamentoSeisMesesSemManutencao = null;
        }
        if(!isset($equipamentoSemManutencao)){
            $equipamentoSemManutencao = null;
        }
        //dd($equipamentoDoisAnosSemManutencao, $equipamentoSeisMesesSemManutencao, $equipamentoUmAnoSemManutencao, $equipamentoSemManutencao);
        return view('site.avisos', compact('equipamentoUmAnoSemManutencao', 'equipamentoDoisAnosSemManutencao', 'equipamentoSeisMesesSemManutencao', 'equipamentoSemManutencao'));

    }
}
