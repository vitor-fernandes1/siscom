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

        $recuperandoDados = DB::table('siscom_equipamento')->paginate(10);
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
        //$class = Equipamento::;
        //dd($class);
        $recuperandoDados =  $this->showTrait($id);
        $recuperandoDados = $recuperandoDados->original['Resposta']['conteudo'] ;
        return view('site.estatistica-id', compact('recuperandoDados') );
        
    }
}
