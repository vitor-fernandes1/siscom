<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\ApiControllerTrait;
use App\Models\Pecunia;

use Illuminate\Support\Facades\Log; //FB remover

use Route;

class PecuniaController extends Controller
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
     * <b>relationships</b> Atributo responsável em guardar informações sobre relacionamentos especificados na models
     * Estes relacionamentos são utilizados entre as models e suas respectivas tabelas.
     * OBS: Caso tenha algum relacionamento na model o mesmo deverá ser descrito o nome do mesmo aqui, para que a ApiControllerTrait
     * Possa utilizar o mesmo em seu método with() presente na consulta do metodo index
     */

    protected $relationships = ['pagamentos','pena','tipoPecunia'];

     /**
     * <b>__construct</b> Método construtor da classe. O mesmo é utilizado, para que atribuir qual a model será utilizada.
     * Essa informação atribuida aqui, fica disponivel na ApiControllerTrait e é utilizada pelos seus metodos.
     */

    public function __construct(Pecunia $model)
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
        //valida se a entidade e o banco existem na requisição ou foram preenchidos
        if($request->has('entidade') && $request->has('banco') || $request->filled('entidade') && $request->filled('banco'))
        {
            $error['message'] = "Não é permitido o cadastro de conta bancaria e entidade ao mesmo tempo";
            $error['error']   = true;

            return $this->createResponse($error, 422);
        }

       //obtem o id da pena
       $idPena = $request->pena;
       $ativo = (Object) $this->model->regraAtivo($idPena);

       if(isset($ativo->error))
       {
           return  $this->createResponse($ativo, 422);
       }

        //chamar o metodo store da Trait para realizar o restante das validações de campos e gravar
        $pecunia = $this->storeTrait($request);
        //Guardar as informações no historico
        $responsePecunia = $pecunia->original['Resposta']['conteudo'];

        if(! isset($responsePecunia->error) )
        {
            //obtem o id da pecunia
            $id = $responsePecunia->id;

            $arrayPecunia = [
                'nr_parcelas_novo'         => $responsePecunia->qtdeParcelas,
                'vl_novo'                  => str_replace(',', '', $responsePecunia->valorTotal),

                'vl_pago_novo'             => isset($responsePecunia->valorPago) ? str_replace(',', '', $responsePecunia->valorPago) : 0,
                'nr_dia_vencimento_novo'   => $responsePecunia->diaVencimento,
                'fk_pk_banco_novo'            => isset($responsePecunia->banco) ? $responsePecunia->banco : '',
                'ds_agencia_novo'          => isset($responsePecunia->agencia) ?$responsePecunia->agencia : '',
                'ds_conta_novo'            => isset($responsePecunia->conta) ? $responsePecunia->conta : '',

                'fk_pk_tipo_pecunia'       => $responsePecunia->tipo,
                'ds_id_origem'         => $responsePecunia->id,
                'ds_tipo_origem'       => "App\Models\Pecunia",
            ];
            //busca a pecunia que foi inserida e insere o historico atraves do relacionamento
            $historicoPecunia = $this->model->find($id);
            $historicoPecunia->historicoPecunias()->create($arrayPecunia);

        }

        return $pecunia;
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

        //valida se a entidade e o banco existem na requisição ou foram preenchidos
        if($request->has('entidade') && $request->has('banco') || $request->filled('entidade') && $request->filled('banco'))
        {
            $error['message'] = "Não é permitido o cadastro de conta bancaria e entidade ao mesmo tempo";
            $error['error']   = true;

            return $this->createResponse($error, 422);
        }

       //obtem o id da pena
       $idPena = $request->pena;
       $ativo = (Object) $this->model->regraAtivo($idPena);

       if(isset($ativo->error))
       {
           return  $this->createResponse($ativo, 422);
       }

        $dadosAnteriores = $this->model->regraHistorico($id, null, $obterDadosAnteriores = 1);
        $dadosAnteriores = (Object) $dadosAnteriores;

         //chamar o metodo store da Trait para realizar o restante das validações de campos e gravar
        $pecunia = $this->updateTrait($request, $id);

        //Guardar as informações no historico
        $responsePecunia = $pecunia->original['Resposta']['conteudo'];

        if(! isset($responsePecunia->error) )
        {

            $dadosAtualizados = $this->model->regraHistorico($id, $dadosAnteriores, $atualizarDados = 2);
            
            if(isset($dadosAtualizados->error))
            {
                return $this->createResponse($historico, 404);
            }

        }

        return $pecunia;

    }


    /**
     * <b>destroy</b> Método responsável em receber a requisição do tipo DELETE e encaminhar a mesma para o metodo index da ApiControllerTrait
     *  @param  int  $id
     *  @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          //chamar e validar regras de negocio
          $delete         =  $this->model->regraExclusao($id);
          $responseDelete = (Object) $delete;

          if(isset($responseDelete->error))
          {
              return $this->createResponse($responseDelete, 422);

          }
          else
          {
            //obtem o controller e a ação
            $action = Route::getCurrentRoute()->getActionName();
            //obtem apenas o nome da ação
            $action = explode('@', $action);
            //atribui valores no array
            $data = [
                'ds_motivo'     => "Exclusão do pecunia {$id} realizada.",
                'ds_acao_motivo'=> $action[1],
                'ds_tipo_motivo'=> 'App\Models\Pecunia',
            ];
            //grava o motivo automatico do motivo da exclusao
            $motivo = $this->model->find($id)->motivos()->create($data);
            //deletar o historico
            $historicoDelete = $this->model->find($id)->historicoPecunias()->delete($id);
            //chamar o metodo delete da Trait  para deletar a multa
            $destroy = $this->destroyTrait($id);

            return $destroy;
          }
    }

    /**
     * <b>ativarOuInativar</b> Metodo responsavel em receber uma requisição do tipo POST, essas requisições são enviadas para
     * Ativar ou Inativar um recurso. Este metodo indentifica qual é a ação que esta sendo solicitada faz a inativação ou ativação
     * do recurso e grava o motivo informado pelo usuário.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ativarOuInativar(Request $request, $id)
    {
        $pecunia = $this->model->find($id);

        if($pecunia != null)
        {
            //obtem o controller e a ação
            $action = url()->current();
            $action = explode('/', $action);
            //obtem apenas o nome da ação
            $action = $action[6];
           //verifica a ação
            if($action == "ativar")
            {
                $ativar = $this->model->find($id)->update(['ds_ativo_pecunia' => 1]);
            }
            else
            {
                $inativar = $this->model->find($id)->update(['ds_ativo_pecunia' => 0]);
            }
            //verificar se o motivo foi preenchido
            if(! $request->filled('descricao') || ! $request->has('descricao'))
            {
                $error['message'] = "Para ativar ou desativar uma pecunia, um motivo deve ser informado !";
                $error['error']   = true;

                return $this->createResponse($error, 422);
            }
            //atribui valores no array
            $data = [
                'ds_motivo'     => $request->descricao,
                'ds_acao_motivo'=> $action,
                'ds_tipo_motivo'=> 'App\Models\Pecunia',
            ];
            //grava o motivo
            $motivo   = $this->model->find($id)->motivos()->create($data);
            //realiza a consulta novamente ao recurso que esta sendo ativado ou inativado
            $response = $this->model->find($id);
            //exibe com os nomes do "mundo externo"
            $response = $this->columnsShow($response);
            return $this->createResponse($response);
        }

        $error['message'] = "O pecunia informada não existe";
        $error['error']   = true;

        return $this->createResponse($error, 404);

    }


}
