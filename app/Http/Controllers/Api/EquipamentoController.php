<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiControllerTrait;
use App\Models\Equipamento;
use Illuminate\Support\Facades\DB;

use Validator;

class EquipamentoController extends Controller
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
    public function index()
    {
        $recuperandoDados = DB::table('siscom_equipamento')->paginate(5);
        //$recuperandoDados = $this->model->get();
        //dd($recuperandoDados);
        return view('site.equipamento', compact('recuperandoDados') );
    }

    /**
     * <b>store</b>Método responsável em receber a requisição do tipo POST, encaminhar para a model validar as regras de negocio e 
     * encaminhar para o metodo store da TRAIT, para que o mesmo realize validação de dados(campos) e realize o cadastro
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        
        dd($request);
        //Validando dados de entrada
        $validate = Validator::make($request->all(), $this->model->rules, $this->model->messages);
        if ($validate->fails()) {
            return redirect()
                        ->route('equipamento.store')
                        ->withErrors($validate)
                        ->withInput();
        }
        
        //Obtendo o numero de referencia do tipo
        $obterTipo = explode(" ", $request->fk_pk_tipo_equipamento);
        $obterTipo = $obterTipo['0'];
        //Convertendo o numero de referencia para inteiro
        $numeroTipo = intval($obterTipo);
        //atualizando a $request com o numero do tipo
        $request->merge(['fk_pk_tipo_equipamento' =>  $numeroTipo]);
        $gravarDados = $this->storeTrait($request);
        dd($gravarDados);
        if($gravarDados['success'])
            return redirect()
                        ->route('equipamento.index')
                        ->with('success', $gravarDados['message']);


        
        //chamar o metodo store da Trait para realizar o restante das validações de campos e gravar
        return $this->storeTrait($request);
    }

    /**
     * <b>show</b> Método responsável em receber a requisição do tipo GET contendo o id do recurso a ser consultado
     *  e encaminhar a mesma para o metodo index da ApiControllerTrait
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $recuperandoDados =  $this->showTrait($id);
        $recuperandoDados = $recuperandoDados->original['Resposta']['conteudo'] ;
        return view('site.equipamentoEditar', compact('recuperandoDados') );
        
    }

    /**
     *<b>update</b>Método responsável em receber a requisição do tipo PUT contendo o id do recurso a ser atualizado, 
     * encaminhar para a model validar as regras de negocio e encaminhar para o metodo store da TRAIT, 
     * para que o mesmo realize validação de dados(campos) e realize o cadastro
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        //dd($request);
        //Validando dados de entrada
        $validate = Validator::make($request->all(), $this->model->rules, $this->model->messages);
        //dd($validate);
        if ($validate->fails()) {
            return back()
                        ->withErrors($validate)
                        ->withInput();
        }
        
        //Obtendo o numero de referencia do tipo
        $obterTipo = explode(" ", $request->fk_pk_tipo_equipamento);
        $obterTipo = $obterTipo['0'];
        //Convertendo o numero de referencia para inteiro
        $numeroTipo = intval($obterTipo);
        //atualizando a $request com o numero do tipo
        $request->merge(['fk_pk_tipo_equipamento' =>  $numeroTipo]);
        //dd($request);
        $atualizarDados = $this->updateTrait($request, $id);
        if($atualizarDados['success'])
            return redirect()
                        ->route('equipamento.index')
                        ->with('success', $atualizarDados['message']);


        
        //chamar o metodo store da Trait para realizar o restante das validações de campos e gravar
        return $this->updateTrait($request, $id);
    }

    
    /**
     * <b>destroy</b> Método responsável em receber a requisição do tipo DELETE e encaminhar a mesma para o metodo index da ApiControllerTrait
     *  @param  int  $id
     *  @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        echo "oláaaaaaaaaaaaaaa";
        dd($request);
        //chamar e validar regras de negocio
        
        //chamar o metodo store da Trait para realizar o restante das validações de campos e gravar
        return $this->destroyTrait($id);
    }
}
