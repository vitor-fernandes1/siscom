<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiControllerTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Equipamento;
use DateTime;
use DateInterval;

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

        //obtendo o valor total das manutenções atreladas ao equipamento selecionado, os valores serao arredondados posteriormente
        $query = DB::select("SELECT SUM(vl_valor_manutencao) as valorTotalManutencao FROM siscom_manutencao WHERE fk_pk_equipamento = $id");

        //Obtendo valores das manutenções
        $custosDeCadaManutencao = DB::select("SELECT vl_valor_manutencao FROM siscom_manutencao WHERE fk_pk_equipamento = $id");

        if(!empty($custosDeCadaManutencao) && $qtdManutencao > 0 && !empty($query)){
            $valorEquipamento = DB::select("SELECT nr_valor_equipamento FROM siscom_equipamento WHERE pk_equipamento = $id");
            $valorEquipamento = $valorEquipamento['0']->nr_valor_equipamento;
            $valorEquipamento = doubleval($valorEquipamento);
            $percentualAumentoTotal = doubleval($query['0']->valorTotalManutencao) ;
            $percentualAumentoTotal = $percentualAumentoTotal / $valorEquipamento ;
            $percentualAumentoTotal = $percentualAumentoTotal * 100 ;
            $percentualAumentoTotal = round($percentualAumentoTotal, 1);
            $indice = 0 ;
            $totalAumento = 0;
            foreach($custosDeCadaManutencao as $valor){
                $valor = doubleval($valor->vl_valor_manutencao);
                //Calculando percentual de aumento p/ cada manutencao
                $calculoPercentual = $valor / $valorEquipamento ;
                $calculoPercentual = $calculoPercentual * 100;
                $calculoPercentual = round($calculoPercentual, 1);
                $percentualAumentoPorManutencao [] = $calculoPercentual ;
                //Calculando percentual total
                $totalAumento = $totalAumento + $calculoPercentual ;
                //Calculando soma dos percentuais de aumento
                if($indice === 0){
                    $somandoPercentualAumento [] = $calculoPercentual ;
                }else{
                    $indice -- ;
                    $somandoPercentualAumento [] = $somandoPercentualAumento["$indice"] + $calculoPercentual ;
                    $indice ++ ;
                }
                $indice ++ ;
            }

            for( $cont = 0 ; $cont < ($qtdManutencao) ; $cont++ ){
                $dataLabelPercentual ["$cont"] = $cont + 1;
            }
            
            //Gerando Gráfico de percentual
            $chartjsPercentual = app()->chartjs
            ->name('percentual')
            ->type('line')
            ->size(['width' => 300, 'height' => 100])
            ->labels($dataLabelPercentual)
            ->datasets([
                [
                "label" => "Por manutenção",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $percentualAumentoPorManutencao,
                ],
                [
                    "label" => "Total",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $somandoPercentualAumento,
                ]
            ])
            ->options([]);

        }else{
            $chartjsPercentual = app()->chartjs
            ->name('percentual')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels([])
            ->datasets([[
                "label" => "Não Houveram manutenções suficientes para gerar o gráfico",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => [],
            ]])
            ->options([]);
        }
        
        //obtendo intervalo em dias entre as datas das manutenções nos ultimos 1 ano, os valores serao arredondados posteriormente(após obter a media de dias)
        $obterDataManutencao = DB::select("SELECT TIMESTAMPDIFF(DAY,dt_manutencao,NOW()) AS dias FROM siscom_manutencao WHERE fk_pk_equipamento = $id AND TIMESTAMPDIFF(DAY,dt_manutencao,NOW()) <= 365 ORDER BY dt_manutencao DESC");        

        if(!empty($query) && !empty($obterDataManutencao) && $qtdManutencao > 1)
        {
            /**TRATANDO DATAS */
            $indice = $qtdManutencao - 1 ;
            $mediaDiasManutencao = 0 ;
            do{
                $intervaloEmDiasEntreManutencao = $obterDataManutencao["$indice"]->dias;
                $indice--;
                if( (isset($obterDataManutencao["$indice"])) === true )
                {
                    $intervaloEmDiasEntreManutencao = $intervaloEmDiasEntreManutencao - $obterDataManutencao["$indice"]->dias ;
                    $mediaDiasManutencao = $mediaDiasManutencao + $intervaloEmDiasEntreManutencao ;
                }
                $validaIndiceAnterior = $indice ;
                $validaIndiceAnterior-- ;
            }while( (isset($obterDataManutencao["$validaIndiceAnterior"])) === true );
            $mediaDiasManutencao = $mediaDiasManutencao / $qtdManutencao ;
            //arredondado número médio de dias
            $mediaDiasManutencao = round($mediaDiasManutencao) ;


            $somaMediaDiasManutencao = $mediaDiasManutencao ;
            //Variavel feita para concatenar a função DateInterval
            $dData = 'D' ;
            //Obtendo o intervalo entre as datas
            for($contFor = 1 ; $contFor <= $qtdManutencao ; $contFor ++ ){
                $data = date_create();
                $data->add( new DateInterval("P$somaMediaDiasManutencao$dData") );
                $data = $data->format('d-m-y');
                $datas [] = $data ;
                $somaMediaDiasManutencao = $somaMediaDiasManutencao + $mediaDiasManutencao ;
            }
            
            /**TRATANDO VALORES */
            $valorTotalManutencao = doubleval($query['0']->valorTotalManutencao) ;
            $valorMedioManutencao = $valorTotalManutencao/$qtdManutencao ;
            $valorMedioManutencao = round($valorMedioManutencao) ;
            $somandoValorMedio = $valorMedioManutencao ;
            $cont = 0 ;
            do{
                $valoresMedios ["$cont"] = $somandoValorMedio ;
                $somandoValorMedio = $somandoValorMedio + $valorMedioManutencao;
                $cont++;
            }while($cont <= ($qtdManutencao - 1));

            /**GERANDO O GRAFICO TIPO LINE*/
            for( $cont = 0 ; $cont < ($qtdManutencao) ; $cont++ ){
                $dataLabel ["$cont"] = $cont + 1;
            }
            $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($datas)
            ->datasets([
                [
                "label" => "1 ano",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $valoresMedios,
                ]
            ])
            ->options([]);
            
            /**GERANDO O GRAFICO TIPO PIE*/
            $chartjs2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Favorável', 'Normal', 'Desfavorável'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                    'data' => [($valorTotalManutencao-$valorMedioManutencao), ($valorTotalManutencao), ($valorTotalManutencao+$valorMedioManutencao)]
                ]
            ])
            ->options([]);

        }else{
            //LINE
            $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels([])
            ->datasets([[
                "label" => "Não Houveram manutenções suficientes para gerar o gráfico",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => [],
            ]])
            ->options([]);
            //PIE
            $chartjs2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Não Houveram manutenções suficientes para gerar o gráfico'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                    'data' => [0]
                ]
            ])
            ->options([]);
        }
        
    
    //** Recomendação do sistema **
    //caso valor das manutenções chegue a 50%(cod. amarelo) e 80%(cod.vermelho) do valor do equipamento, 
    //caso a vida util seja inferior a 70%(cod. amarelo) e 40%(cod.vermelho)

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

    $codRecomendacao = 0 ;
    $flagVidaUtil = false ;
    if(isset($totalAumento) && $totalAumento >= 50 && $totalAumento < 80){
        $codRecomendacao = 2 ;
        if($porcentagemBarra <= 70){
            $flagVidaUtil = true ;
        }
    }else if(isset($totalAumento) && $totalAumento >= 80){
        $codRecomendacao = 1 ;
        if($porcentagemBarra <= 40){
            $flagVidaUtil = true ;
        }
    }
    
        return view('site.grafico-id', compact('chartjs', 'chartjs2','chartjsPercentual','recuperandoDados', 'codRecomendacao','porcentagemBarra', 'flagVidaUtil') );
        
    }
}
