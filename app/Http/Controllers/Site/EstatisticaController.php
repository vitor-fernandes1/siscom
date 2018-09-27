<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiControllerTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Equipamento;

class EstatisticaController extends Controller
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
        return view('site.estatistica', compact('recuperandoDados') );
    }
    /**
     * <b>show</b> Método responsável em receber a requisição do tipo GET contendo o id do recurso a ser consultado
     *  e encaminhar a mesma para o metodo index da ApiControllerTrait
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //dd($id);
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

        //obtendo Manutenções em andamento atreladas ao equipamento 1-Em Andamento 2-Pendente 3-Concluido
        $verificaQtdManutencao = DB::table('siscom_manutencao')->where('fk_pk_situacao', 1)->count();
        $manutencaoEmAndamento = null ;
        if($verificaQtdManutencao != 0)
        {
            $obterManutencaoEmAndamento = DB::table('siscom_manutencao')->where('fk_pk_situacao', 1)->get();
            foreach($obterManutencaoEmAndamento as $item)
            {
                $manutencaoEmAndamento [] = $item;
            }
        }

        //obtendo Manutenções concluidas atreladas ao equipamento 1-Em Andamento 2-Pendente 3-Concluido
        $verificaQtdManutencao = DB::table('siscom_manutencao')->where('fk_pk_situacao', 1)->count();
        $manutencaoConcluida = null ;
        if($verificaQtdManutencao != 0)
        {
            $obterManutencaoConcluida = DB::table('siscom_manutencao')->where('fk_pk_situacao', 3)->get(); 
            foreach($obterManutencaoConcluida as $item)
            {
                $manutencaoConcluida [] = $item;
            }
        }

        //obtendo Manutenções Pendentes atreladas ao equipamento 1-Em Andamento 2-Pendente 3-Concluido
        $verificaQtdManutencao = DB::table('siscom_manutencao')->where('fk_pk_situacao', 1)->count();
        $manutencaoPendente = null ;
        if($verificaQtdManutencao != 0)
        {
            $obterManutencaoPendente = DB::table('siscom_manutencao')->where('fk_pk_situacao', 2)->get();
            foreach($obterManutencaoPendente as $item)
            {
                $manutencaoPendente [] = $item;
            }
        }

        //obtendo manutenções nos ultimos 6 meses
        $dadosUltimosSeisMeses = DB::select("SELECT * FROM siscom_manutencao WHERE dt_manutencao BETWEEN CURDATE() - INTERVAL 6 MONTH AND CURDATE() AND fk_pk_equipamento = $id");
        if(empty($dadosUltimosSeisMeses))
        {
            $dadosUltimosSeisMeses = null ;
        }

        //obtendo manutenções nos ultimos 3 meses
        $dadosUltimosTresMeses = DB::select("SELECT * FROM siscom_manutencao WHERE dt_manutencao BETWEEN CURDATE() - INTERVAL 3 MONTH AND CURDATE() AND fk_pk_equipamento = $id");
        if(empty($dadosUltimosTresMeses))
        {
            $dadosUltimosTresMeses = null ;
        }

        //obtendo manutenções no ultimo ano
        $dadosUltimoAno = DB::select("SELECT * FROM siscom_manutencao WHERE dt_manutencao BETWEEN CURDATE() - INTERVAL 1 Year AND CURDATE() AND fk_pk_equipamento = $id");
        if(empty($dadosUltimoAno))
        {
            $dadosUltimoAno = null ;
        }

        return view('site.estatistica-id', compact('recuperandoDados', 'valorTotalManutencao', 'valorTotalEquipamento', 'qtdManutencao', 'manutencaoConcluida', 'manutencaoEmAndamento', 'manutencaoPendente', 'dadosUltimoAno', 'dadosUltimosSeisMeses', 'dadosUltimosTresMeses') );
        
    }
}
