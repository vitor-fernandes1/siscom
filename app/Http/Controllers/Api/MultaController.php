<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\ApiControllerTrait;

use App\Models\Multa;

use App\Models\HistoricoMulta;

use Route;

use App\HelpersTrait;

use Carbon\Carbon;

class MultaController extends Controller
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
     * <b>HelpersTrait</b> Trait que contém alguns helpers de validação de dados tais como replace de caracteres de data, calculo
     * de cpf e cnpj entre outros
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
    protected $relationships = ['pena','pagamentos','tipoMulta'];

    /**
     * <b>__construct</b> Método construtor da classe. O mesmo é utilizado, para que atribuir qual a model será utilizada.
     * Essa informação atribuida aqui, fica disponivel na ApiControllerTrait e é utilizada pelos seus metodos.
    */
    public function __construct(Multa $model)
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

        //verifica se esta preenchido converte a data de calculo recebida
        if($request->filled('dataCalculo') && $request->has('dataCalculo'))
        {
            $request->dataCalculo = $this->formatData($request->dataCalculo);
            $request->dataCalculo =  Carbon::parse($request->dataCalculo)->toDateTimeString();
            $request->merge(['dataCalculo' => $request->dataCalculo]);
        }
        //obtem o id da pena
        $idPena = $request->pena;
        $ativo = (Object) $this->model->regraAtivo($idPena);

        if(isset($ativo->error))
        {
           return  $this->createResponse($ativo, 422);
        }


        //chamar o metodo store da Trait para realizar o restante das validações de campos e gravar
        $multa = $this->storeTrait($request);

        $responseMulta = $multa->original['Resposta']['conteudo'];
        if(! isset($responseMulta->error) )
        {
            //obtem o id da multa
            $id = $responseMulta->id;

            //cria um array com os dados do historico
            $arrayHistorico = [
                'vl_novo'              => str_replace(',', '',$responseMulta->valorTotal),
                'nr_parcelas_novo'     => $responseMulta->qtdeParcelas,
                'vl_pago_novo'         => isset($responseMulta->valorPago) ? str_replace(',', '',$responseMulta->valorPago) : 0,
                'dt_calculo_novo'      => $responseMulta->dataCalculo,
                // 'fk_pk_banco'          => $responseBanco->nome, // FIXME: precisa pegar o banco externamente para gravar na Histórico!?

                'fk_pk_banco_novo'     => $request->banco,
                'ds_agencia_novo'      => $request->agencia,
                'ds_conta_novo'        => $request->conta,
                'fk_pk_tipo_multa_novo'=> $responseMulta->tipo,
                'ds_id_origem'         => $responseMulta->id,
                'ds_tipo_origem'       => "App\Models\Multa",
            ];
            //busca a multa que foi inserida e insere o historico atraves do relacionamento
            // FIXME: Verificar gravacao do banco na tabela histórico multa
            $historicoMulta = $this->model->find($id);
            $historicoMulta->historicoMultas()->create($arrayHistorico);
        }

        return $multa;



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

        //verifica se esta preenchido e converte a data de calculo recebida
        if($request->filled('dataCalculo') && $request->has('dataCalculo'))
        {
            $request->dataCalculo = $this->formatData($request->dataCalculo);
            $request->dataCalculo =  Carbon::parse($request->dataCalculo)->toDateTimeString();
            $request->merge(['dataCalculo' => $request->dataCalculo]);
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
        $multa = $this->updateTrait($request, $id);

        $responseMulta = $multa->original['Resposta']['conteudo'];
        if(! isset($responseMulta->error) )
        {

            $dadosAtualizados = $this->model->regraHistorico($id, $dadosAnteriores, $atualizarDados = 2);
            
            if(isset($dadosAtualizados->error))
            {
                return $this->createResponse($historico, 404);
            }
            
        }

        return $multa;
    }


    /**
     * <b>destroy</b> Método responsável em receber a requisição do tipo DELETE e encaminhar a mesma para o metodo destroy da ApiControllerTrait
     *  @param  int  $id
     *  @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //chamar e validar regras de negocio
        $delete =  $this->model->regraExclusao($id);
        $responseDelete =  $delete;
        if(isset($responseDelete['error']))
        {
            return $this->createResponse($responseDelete, 405);

        }else
        {
             //obtem o controller e a ação
             $action = Route::getCurrentRoute()->getActionName();
             //obtem apenas o nome da ação
             $action = explode('@', $action);
             //atribui valores no array
             $data = [
                 'ds_motivo'     => "Exclusão da multa {$id} realizada.",
                 'ds_acao_motivo'=> $action[1],
                 'ds_tipo_motivo'=> 'App\Models\Multa',
             ];
            //grava o motivo automatico do motivo da exclusao
            $motivo = $this->model->find($id)->motivos()->create($data);
            //deletar o historico
            $historicoDelete = $this->model->find($id)->historicoMultas()->delete($id);
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

        $multa = $this->model->find($id);

        if($multa != null)
        {
            //obtem o controller e a ação
            $action = url()->current();
            $action = explode('/', $action);
            //obtem apenas o nome da ação
            $action = $action[6];
           //verifica a ação
            if($action == "ativar")
            {
                $ativar = $this->model->find($id)->update(['ds_ativo_multa' => 1]);
            }
            else
            {
                $inativar = $this->model->find($id)->update(['ds_ativo_multa' => 0]);
            }
            //verificar se o motivo foi preenchido
            if(! $request->filled('descricao') || ! $request->has('descricao'))
            {
                $error['message'] = "Para ativar ou desativar uma multa, um motivo deve ser informado !";
                $error['error']   = true;

                return $this->createResponse($error, 422);
            }
            //atribui valores no array
            $data = [
                'ds_motivo'     => $request->descricao,
                'ds_acao_motivo'=> $action,
                'ds_tipo_motivo'=> 'App\Models\Multa',
            ];
            //grava o motivo
            $motivo   = $this->model->find($id)->motivos()->create($data);
            //realiza a consulta novamente ao recurso que esta sendo ativado ou inativado
            $response = $this->model->find($id);
            //exibe com os nomes do "mundo externo"
            $response = $this->columnsShow($response);
            return $this->createResponse($response);
        }

        $error['message'] = "A multa informada não existe";
        $error['error']   = true;

        return $this->createResponse($error, 404);

    }





}
