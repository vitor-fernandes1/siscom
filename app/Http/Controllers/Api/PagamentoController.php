<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\ApiControllerTrait;
use App\Models\Pagamento;

use App\Models\Multa;
use App\Models\Pecunia;
use App\Models\Custas;

use App\HelpersTrait;

use Carbon\Carbon;



class PagamentoController extends Controller
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

    protected $relationships = [];

    /**
     * <b>__construct</b> Método construtor da classe. O mesmo é utilizado, para que atribuir qual a model será utilizada.
     * Essa informação atribuida aqui, fica disponivel na ApiControllerTrait e é utilizada pelos seus metodos.
     */

    public function __construct(Pagamento $model)
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
        //valida os campos submetidos pelo usuário
        $validate = $this->validateInputs($request);
        $responseValidate =  $validate->original['Resposta']['conteudo'];

        if(isset($responseValidate->error))
        {
            return $validate;

        }
        //verifica se esta preenchido converte a data de calculo recebida
        if($request->filled('data') && $request->has('data'))
        {
            $request->data = $this->formatData($request->data);
            $request->data = Carbon::parse($request->data)->toDateTimeString();
            $request->merge(['data' => $request->data]);
        }
        //obtem o id da custas, multa ou pecunia
        $IdOrigem  = $request->origemId;
        //obtem o tipo de pagamento informado pelo usuário
        $type = $request->origem;
        $tipo = (Object) $this->model->regraTipo($type);
        if(isset($tipo->error))
        {
            return $this->createResponse($tipo, 404);
        }

        //Atribui o namescapace da classe responsavel
        $tipo = $tipo->scalar;
        //Atribui o valor do namespace
        $request->merge(['origem' => $tipo]);

        //Verifica se uma custas multa ou pecunia esta ativa
        $ativo = (Object) $this->model->regraAtivo($request->origemId, $type);

        if(isset($ativo->error))
        {
            return  $this->createResponse($ativo, 422);
        }

        if($tipo == "App\Models\Custas")
        {
            $dadosDoPagamentoInformado = Custas::find($IdOrigem);
            $valorPagoCadastradoAnterior = $dadosDoPagamentoInformado->vl_pago_custas;
        }
        else if($tipo == "App\Models\Multa")
        {
            $dadosDoPagamentoInformado = Multa::find($IdOrigem);
            $valorPagoCadastradoAnterior = $dadosDoPagamentoInformado->vl_multa_pago;
        }
        else
        {
            $dadosDoPagamentoInformado = Pecunia::find($IdOrigem);
            $valorPagoCadastradoAnterior = $dadosDoPagamentoInformado->vl_pago_pecunia;
        }

        //chamar o metodo store da Trait para realizar o restante das validações de campos e gravar
        $pagamento = $this->storeTrait($request);
        $responsePagamento = $pagamento->original['Resposta']['conteudo'];
        $saldo = $this->model->regraSaldo($IdOrigem,  str_replace(',', '',$request->valor), $type);
        
        $IdPagamento = $responsePagamento->id;
        
        if(! isset($responsePagamento->error) )
        {
                $historico = $this->model->regraHistorico($valorPagoCadastradoAnterior, $request, $type, $IdOrigem);
                $historico = (Object) $historico;

                if(isset($historico->error))
                {
                    return $this->createResponse($historico, 404);
                }
        }

        return $pagamento;
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

        //valida os campos submetidos pelo usuário
        $validate = $this->validateInputs($request);
        $responseValidate =  $validate->original['Resposta']['conteudo'];

        if(isset($responseValidate->error))
        {
            return $validate;

        }
        //verifica se esta preenchido converte a data de calculo recebida
        if($request->filled('data') && $request->has('data'))
        {
            $request->data = $this->formatData($request->data);
            $request->data = Carbon::parse($request->data)->toDateTimeString();
            $request->merge(['data' => $request->data]);
        }

        //obtem o id da custas, multa ou pecunia
        $IdPagamento  = $request->origemId;
        //obtem o tipo de pagamento informado pelo usuário
        $type = $request->origem;

        $tipo = (Object) $this->model->regraTipo($type);

        if(isset($tipo->error))
        {
            return $this->createResponse($tipo, 404);
        }

        //Atribui o namescapace da classe responsavel
        $tipo = $tipo->scalar;

        //Atribui o valor do namespace
        $request->merge(['origem' => $tipo]);

        //Verifica se uma custas multa ou pecunia esta ativa
        $ativo = (Object) $this->model->regraAtivo($IdPagamento, $type);

        if(isset($ativo->error))
        {
            return  $this->createResponse($ativo, 422);
        }

        $pagamento = Pagamento::find($id);
        if($tipo == "App\Models\Custas")
        {
            $dadosDoPagamentoInformado = Custas::find($IdPagamento);
            $valorPagoCadastradoAnterior = $dadosDoPagamentoInformado->vl_pago_custas;
            //cria o array contendo os dados anteriores de valores pagos do id da pagamento passado, e realiza os calculos para atualizar o Servico.
            $dadosAnterioresPagamento =
            [
                'vl_pago_custas'      => $valorPagoCadastradoAnterior - ($pagamento->vl_pago_pagamento),
            ];
            //Atualiza o valor pago de acordo com os dados Anteriores do pagamento
            Custas::where('PK_CUSTAS', $IdPagamento)->update($dadosAnterioresPagamento);
        }
        else if($tipo == "App\Models\Multa")
        {
            $dadosDoPagamentoInformado = Multa::find($IdPagamento);
            $valorPagoCadastradoAnterior = $dadosDoPagamentoInformado->vl_multa_pago;
            //cria o array contendo os dados anteriores de valores pagos do id da pagamento passado, e realiza os calculos para atualizar o Servico.
            $dadosAnterioresPagamento =
            [
                'vl_multa_pago'      => $valorPagoCadastradoAnterior - ($pagamento->vl_pago_pagamento),
            ];
            //Atualiza o valor pago de acordo com os dados Anteriores do pagamento
            Multa::where('PK_MULTA', $IdPagamento)->update($dadosAnterioresPagamento);
        }
        else
        {
            $dadosDoPagamentoInformado = Pecunia::find($IdPagamento);
            $valorPagoCadastradoAnterior = $dadosDoPagamentoInformado->vl_pago_pecunia;
            //cria o array contendo os dados anteriores de valores pagos do id da pagamento passado, e realiza os calculos para atualizar o Servico.
            $dadosAnterioresPagamento =
            [
                'vl_pago_pecunia'      => $valorPagoCadastradoAnterior - ($pagamento->vl_pago_pagamento),
            ];
            //Atualiza o valor pago de acordo com os dados Anteriores do pagamento
            Pecunia::where('PK_PECUNIA', $IdPagamento)->update($dadosAnterioresPagamento);
        }

        //chamar o metodo store da Trait para realizar o restante das validações de campos e gravar
        $updatePagamento = $this->updateTrait($request, $id);
        $responsePagamento = $updatePagamento->original['Resposta']['conteudo'];
        $saldo = $this->model->regraSaldo($IdPagamento,  str_replace(',', '',$request->valor), $type);

        if(! isset($responsePagamento->error) )
        {
                $historico = $this->model->regraHistorico($valorPagoCadastradoAnterior, $request, $type, $IdPagamento);

                if(isset($historico->error))
                {
                    return $this->createResponse($historico, 404);
                }
        }

        return $updatePagamento;
    }


    /**
     * <b>destroy</b> Método responsável em receber a requisição do tipo DELETE e encaminhar a mesma para o metodo index da ApiControllerTrait
     *  @param  int  $id
     *  @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $error['message'] = "Ação não permitida. Para excluir um Pagamento deverá ser informado um motivo.";
        $error['error']   = true;

        return  $this->createResponse($error, 405);
    }


    /**
     * <b>excluir</b> Método responsável em receber a requisição do tipo POST (com o campo motivoExclusao preenchido e com o id do registro que será excluido logicamente)
     * atualizar o valor do campo ds_exclusao_pagamento e após atualizar excluir o mesmo.
     * @param \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function excluir(Request $request, $id)
    {

        $query =  $this->model->find($id);

        if(! is_null($query))
        {
            //obtendo o id de origem
            $idOrigem = $query->ds_id_pagamento ;
            //Obtendo o tipo
            $tipo = $query->ds_tipo_pagamento ;
            //exibi o resultado da consulta de acordo com os nomes do "mundo externo"
            $query =  (Object) $this->columnsShow($query);
            //inicialmente a requisição so recebe o campo motivoExclusão esses outros são criados apartir da consulta
            $request->request->add([
                'data'              => $query->data,
                'valor'             => $query->valor,
                'numComprovante'    => $query->numComprovante,
                //'referencia'        => $query->referencia,
                'observacoes'       => $query->observacoes,
                'origem'            => $query->origem,
                'origemId'          => $query->origemId,
            ]);
            if($tipo == "App\Models\Custas")
            {
                $dadosDoPagamentoInformado = Custas::find($idOrigem);
                $valorPagoCadastradoAnterior = $dadosDoPagamentoInformado->vl_pago_custas;

                //subtraindo o total cancelado para atualizar
                $dadosDoPagamentoInformado->vl_pago_custas = $dadosDoPagamentoInformado->vl_pago_custas - $query->valor;
            }
            else if($tipo == "App\Models\Multa")
            {
                $dadosDoPagamentoInformado = Multa::find($idOrigem);
                $valorPagoCadastradoAnterior = $dadosDoPagamentoInformado->vl_multa_pago;

                //subtraindo o total cancelado para atualizar
                $dadosDoPagamentoInformado->vl_multa_pago = $dadosDoPagamentoInformado->vl_multa_pago - $query->valor;
            }
            else
            {
                $dadosDoPagamentoInformado = Pecunia::find($idOrigem);
                $valorPagoCadastradoAnterior = $dadosDoPagamentoInformado->vl_pago_pecunia;

                //subtraindo o total cancelado para atualizar
                $dadosDoPagamentoInformado->vl_pago_pecunia = $dadosDoPagamentoInformado->vl_pago_pecunia - $query->valor;
            }
            
            $data = $dadosDoPagamentoInformado->toArray();
            //atualizando o serviço subtraindo o valor do pagamento excluido
            $dadosDoPagamentoInformado->update($data);
            //atualizar o saldo antes de excluir um pagamento
            $delete = $this->destroyTrait($id);

            $historico = $this->model->regraHistorico($valorPagoCadastradoAnterior, $request, $tipo, $idOrigem);

            if(isset($historico->error))
            {
                return $this->createResponse($historico, 404);
            }

            return $delete;

        }

        $error['message'] = "A Frequência informada não existe !";
        $error['error']   = true;

        return $this->createResponse($error, 405);

    }




}
