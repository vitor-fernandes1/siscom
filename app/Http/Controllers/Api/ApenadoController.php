<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Http\Controllers\Api\ApiControllerTrait;

use App\HelpersTrait;
use App\Models\Apenado;
use App\Models\TipoDocumento;

use Route;

class ApenadoController extends Controller
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
     * <b>use HelpersTrait</b> Usa a Trait que possui alguns helpers de validação, entre eles calculo de CPF e CNPJ
     */
    use HelpersTrait;
    /**
     * <b>model</b> Atributo responsável em guardar informações a respeito de qual model a controller ira utilizar. 
     * Por causa do D.I (injeção de dependencia feita) o mesmo armazena um objeto da classe que ira ser utilizada.
     * OBS: Este atributo é utilizado na ApiControllerTrait, para diferenciar qual classe esta utilizando os seus recursos
     */

     protected $model;

    /**
     * <b>relationships</b> Atributo responsável em guardar informações sobre relacionamentos especificados na models
     * Estes relacionamentos são utilizados entre as models e suas respectivas tabelas.
     * OBS: Caso tenha algum relacionamento na model o mesmo deverá ser descrito o nome do mesmo aqui, para que a ApiControllerTrait
     * Possa utilizar o mesmo em seu método with() presente na consulta do metodo index
     */
     protected $relationships = ['pena', 'enderecos', 'tipoDocumento'];
     
     /**
     * <b>__construct</b> Método construtor da classe. O mesmo é utilizado, para que atribuir qual a model será utilizada.
     * Essa informação atribuida aqui, fica disponivel na ApiControllerTrait e é utilizada pelos seus metodos.
     */
     public function __construct(Apenado $model)
     {
         $this->model = $model;
     }


    /**
     * <b>index</b> Método responsável em receber a requisição do tipo GET e encaminhar a mesma para o metodo index da ApiControllerTrait
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       return  $this->indexTrait($request);  
    }

    /**
     * <b>store</b>Método responsável em receber a requisição do tipo POST, encaminhar para a model validar as regras de negocio e 
     * encaminhar para o metodo store da TRAIT, para que o mesmo realize validação de dados(campos) e realize o cadastro
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $validate = $this->validateInputs($request);
        $responseValidate =  $validate->original['Resposta']['conteudo'];

        if(isset($responseValidate->error))
        {
            return $validate;

        }
        //verificar o tipo de documento
        $tipoDocumento = (Object) TipoDocumento::find($request->tipoDocumento);
       
        if($tipoDocumento == null)
        {
            $error['message'] = "Tipo de documento informado, não existe!";
            $error['error']   = true;

            return $this->createResponse($error, 422);       
        }

        //Verifica se o Documento já foi cadastrado
        $verificaDocumento = (Object) $this->model->regraDocumento($request->documento);
        if(isset($verificaDocumento->error))
        {
            return  $this->createResponse($verificaDocumento, 422);
        }

        //tipo de documentos cadastrados
        $tipoDocumento        = $tipoDocumento->toArray();
        //atributo estatico que contem o espelhamento dos tipos de documentos cadastrados
        $documentosPermitidos = $this->model::getTipoDocumento();
        //realiza tratamento de string retirando os espaços desnecessários
        $tipoDocumento['nm_tipo_documento'] = trim($tipoDocumento['nm_tipo_documento']);

        //caso seja CPF
        if($tipoDocumento['nm_tipo_documento'] == $documentosPermitidos[1])
        {
            //chamar e validar regras de negocio
            $validaCPF = $this->cpfOuCnPj($request->documento);
            if(! $validaCPF)
            {
                $error['message'] = "O CPF informado é invalido !";
                $error['error']   = true;

                return $this->createResponse($error, 422);
            }
        }

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

        return $this->showTrait($id);
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
        $validate = $this->validateInputs($request);
        $responseValidate =  $validate->original['Resposta']['conteudo'];

        if(isset($responseValidate->error))
        {
            return $validate;

        }
        //verificar o tipo de documento
        $tipoDocumento = (Object) TipoDocumento::find($request->tipoDocumento);
       
        if($tipoDocumento == null)
        {
            $error['message'] = "Tipo de documento informado, não existe!";
            $error['error']   = true;

            return $this->createResponse($error, 422);       
        }

        //Verifica se o Documento já foi cadastrado
        $verificaDocumento = (Object) $this->model->regraDocumento($request->documento, $id);
        if(isset($verificaDocumento->error))
        {
            return  $this->createResponse($verificaDocumento, 422);
        }

        //tipo de documentos cadastrados
        $tipoDocumento        = $tipoDocumento->toArray();
        //atributo estatico que contem o espelhamento dos tipos de documentos cadastrados
        $documentosPermitidos = $this->model::getTipoDocumento();
        //realiza tratamento de string retirando os espaços desnecessários
        $tipoDocumento['nm_tipo_documento'] = trim($tipoDocumento['nm_tipo_documento']);

        //caso seja CPF
        if($tipoDocumento['nm_tipo_documento'] == $documentosPermitidos[1])
        {
            //chamar e validar regras de negocio
            $validaCPF = $this->cpfOuCnPj($request->documento);
            if(! $validaCPF)
            {
                $error['message'] = "O CPF informado é invalido !";
                $error['error']   = true;

                return $this->createResponse($error, 422);
            }
        }

        //chamar o metodo store da Trait para realizar o restante das validações de campos e gravar
        return $this->updateTrait($request, $id);
    }

    
    /**
     * <b>destroy</b> Método responsável em receber a requisição do tipo DELETE e encaminhar a mesma para o metodo index da ApiControllerTrait
     *  @param  int  $id
     *  @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //chamar e validar regras de negocio
        $delete = $this->model->regraExclusao($id);
        $responseDelete =  (Object) $delete;
        
        if(isset($responseDelete->error))
        {
            return $this->createResponse($responseDelete, 422);

        }else
        {
            //obtem o controller e a ação
            $action = Route::getCurrentRoute()->getActionName();
            //obtem apenas o nome da ação
            $action = explode('@', $action);
             //atribui valores no array
            $data = [
                'ds_motivo'     => "Exclusão da apenado {$id} realizada.",
                'ds_acao_motivo'=> $action[1],
                'ds_tipo_motivo'=> 'App\Models\Apenado',
            ];
            //grava o motivo automatico do motivo da exclusao
            $motivo = $this->model->find($id)->motivos()->create($data);
            //chamar o metodo delete da Trait  para deletar a multa
            $destroy = $this->destroyTrait($id);

            return $destroy;
        }
    }

 

}
