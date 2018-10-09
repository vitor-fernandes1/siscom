<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiControllerTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Equipamento;

class GraficoController extends Controller
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
        return view('site.grafico', compact('recuperandoDados') );
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

        //Quantidade de mautenções realizadas
        $qtdManutencao = DB::table('siscom_manutencao')->where('fk_pk_equipamento', $id)->count();

        //obtendo o valor das manutenções atreladas ao equipamento
        $obterValorManutencao = DB::table('siscom_manutencao')->select('vl_valor_manutencao')->where('fk_pk_equipamento', $id)->get(); 
        $valorTotalManutencao = 0 ;
        foreach($obterValorManutencao as $item)
        {
            $valorTotalManutencao += doubleval($item->vl_valor_manutencao);
        }
        //Valor total do equipamento manutencoes + valor equipamento
        $valorTotalEquipamento = ($recuperandoDados->nr_valor_equipamento + $valorTotalManutencao);
        if($valorTotalManutencao != 0){
            $valorMedioManutencao = $valorTotalManutencao/$qtdManutencao ;
            $somandoValoresMedios = $valorMedioManutencao ;
            $cont = 1 ;
                do{
                    $valores ["$cont"] = $somandoValoresMedios;
                    $somandoValoresMedios = $somandoValoresMedios + $valorMedioManutencao;
                    $cont++;
                }while($cont <= $qtdManutencao);
        }
        if($qtdManutencao === 0){
                $chartjs = app()->chartjs
                ->name('lineChartTest')
                ->type('line')
                ->size(['width' => 400, 'height' => 200])
                ->labels([''])
                ->datasets([
                    [
                        "label" => "Não houveram manutenções",
                        'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                        'borderColor' => "rgba(38, 185, 154, 0.7)",
                        "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                        "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                        "pointHoverBackgroundColor" => "#fff",
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => [0],
                    ],
                ])
                ->options([]);
        }else if($qtdManutencao == 1){
            $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels([
                '1'
                ])
            ->datasets([
                [
                    "label" => "1 ano",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [$valores['1']],
                ],
            ])
            ->options([]);
        }else if($qtdManutencao == 2){
            $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels([
                '1', '2'
                ])
            ->datasets([
                [
                    "label" => "1 ano",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [$valores['1'],$valores['2']],
                ],
            ])
            ->options([]);
        }else if($qtdManutencao == 3){
            $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels([
                '1', '2', '3'
                ])
            ->datasets([
                [
                    "label" => "1 ano",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [ $valores['1'], $valores['2'], $valores['3'] ],
                ],
            ])
            ->options([]);
        }else if($qtdManutencao == 4){
            $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels([
                '1', '2', '3', '4'
                ])
            ->datasets([
                [
                    "label" => "Custo",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [ $valores['1'], $valores['2'], $valores['3'], $valores['4'] ],
                ],
            ])
            ->options([]);
        }else if($qtdManutencao == 5){
            $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels([
                '1', '2', '3', '4', '5'
                ])
            ->datasets([
                [
                    "label" => "1 ano",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [ $valores['1'], $valores['2'], $valores['3'], $valores['4'], $valores['5'] ],
                ],
            ])
            ->options([]);
        }else if($qtdManutencao == 6){
            $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels([
                '1', '2', '3', '4', '5', '6'
                ])
            ->datasets([
                [
                    "label" => "1 ano",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [ $valores['1'], $valores['2'], $valores['3'], $valores['4'], $valores['5'], $valores['6'] ],
                ],
            ])
            ->options([]);
        }else if($qtdManutencao == 7){
            $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels([
                '1', '2', '3', '4', '5', '6', '7'
                ])
            ->datasets([
                [
                    "label" => "Custo",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [ $valores['1'], $valores['2'], $valores['3'], $valores['4'], $valores['5'], $valores['6'], $valores['7'] ],
                ],
            ])
            ->options([]);
        }

    //obtendo manutenções no ultimo ano
    $dadosUltimoAno = DB::select("SELECT * FROM siscom_manutencao WHERE dt_manutencao BETWEEN CURDATE() - INTERVAL 1 Year AND CURDATE() AND fk_pk_equipamento = $id");
    if(!empty($dadosUltimoAno))
    {
        $valorManutencaoUltimoAno = 0 ;
        foreach($dadosUltimoAno as $item){
            $valorManutencaoUltimoAno = $valorManutencaoUltimoAno + $item->vl_valor_manutencao;
        }
        //Arredondando valores
        $valorManutencaoUltimoAno = round($valorManutencaoUltimoAno);
        //Obtendo o valor médio das manutenções dos ultimos 1 ano
        $valorMedioManutencaoUltimoAno = $valorManutencaoUltimoAno / count($dadosUltimoAno);
        //Arredondando valores
        $valorMedioManutencaoUltimoAno = round($valorMedioManutencaoUltimoAno);
        //Gerando gráfico
        $chartjs2 = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Valor a ser gasto estimatimado em 1 ano: Favorável', 'Valor a ser gasto estimatimado em 1 ano: Normal', 'Valor a ser gasto estimatimado em 1 ano: Desfavorável'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                'data' => [($valorManutencaoUltimoAno-$valorMedioManutencao), ($valorManutencaoUltimoAno), ($valorManutencaoUltimoAno+$valorMedioManutencaoUltimoAno)]
            ]
        ])
        ->options([]);
    }else{
        $chartjs2 = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Não houveram manutenções'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                'data' => [0]
            ]
        ])
        ->options([]);
    }
    

    

        return view('site.grafico-id', compact('chartjs', 'chartjs2','recuperandoDados', 'valorTotalManutencao', 'valorTotalEquipamento', 'qtdManutencao', 'manutencaoConcluida', 'manutencaoEmAndamento', 'manutencaoPendente', 'dadosUltimoAno', 'dadosUltimosSeisMeses', 'dadosUltimosTresMeses') );
        
    }
}
