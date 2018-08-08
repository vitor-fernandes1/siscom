<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\ApiControllerTrait;
use App\Models\Frequencia;
use App\Models\Servico;

use Illuminate\Support\Facades\DB;
use App\HelpersTrait;

use Carbon\Carbon;
use Input;

class FrequenciaController extends Controller
{
    /**
     * <b>HelpersTrait</b> Trait que contém alguns helpers tais como: validação de cpf e cnpj, validação de formato
     * de e-mail, replace de data entre outros
     */
    use HelpersTrait;
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
        createResponse as protected createResponseTrait;
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
    protected $relationships = ['servico','tipoFrequencia'];

     /**
     * <b>__construct</b> Método construtor da classe. O mesmo é utilizado, para que atribuir qual a model será utilizada.
     * Essa informação atribuida aqui, fica disponivel na ApiControllerTrait e é utilizada pelos seus metodos.
     */

    public function __construct(Frequencia $model)
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

        if( isset($responseValidate->error))
        {
            return $validate;
        }

        //obtem o id da servico e o tipo de frequencia
        $idServico      = $request->servico;
        $tipoFrequencia = $request->tipo;

        //Verifica se o serviço esta ativo
        $regraAtivo = (Object) $this->model->regraAtivo($idServico);

        if( isset($regraAtivo->error) )
        {
            return  $this->createResponse($regraAtivo, 422);
        }
        //caso a frequencia seja mensal
        if($request->has('total') && $request->has('dataHoraEntrada'))
        {
            $regraTipo = (Object) $this->model->regraTipoFrequencia($idServico, $tipoFrequencia, $request->dataHoraEntrada);

            if( isset($regraTipo->error) )
            {
                return  $this->createResponse($regraTipo, 422);
            }

            $frequencia = $this->frequenciaMensal($request);

            //converte o total informado no request para minutos para ser gravado no BD
            $request->merge(['total' =>  $frequencia->total * 60]);

            if( isset($frequencia->original['Resposta']['conteudo']) && isset($frequencia->original['Resposta']['conteudo']->error) )
            {
                return  $frequencia;
            }

            $servico = Servico::find($idServico);
            $dadosAnteriores = $this->model->regraHistorico($idServico, null, $obterDadosAnteriores = 1, null);
            $dadosAnteriores = (Object) $dadosAnteriores;

            $frequenciaStore =  $this->storeTrait($frequencia);

            $sensibilizar = $frequencia->sensibilizado;

            $responseFrequencia = $frequenciaStore->original['Resposta']['conteudo'];

            //atualiza o saldo
            $regraSaldo = $this->model->regraSaldo($servico->nr_min_prestados_servico, null,  null, $frequencia->total);

            //cria o array apartir do indice e atualiza o saldo
            $saldo = [
                     'nr_min_prestados_servico'      => $regraSaldo,
                     'nr_min_sensibilizados_servico' => $servico->nr_min_sensibilizados_servico + $sensibilizar,
                    ];
        }
        //caso a frequencia seja diaria
        else if($request->has('dataHoraEntrada') && $request->has('dataHoraSaida'))
        {
            $regraTipo = (Object) $this->model->regraTipoFrequencia($idServico, $tipoFrequencia, $request->dataHoraEntrada);

            if( isset($regraTipo->error) )
            {
                return  $this->createResponse($regraTipo, 422);
            }

            $frequencia = (Object) $this->frequenciaDiaria($request);


            if( isset($frequencia->original['Resposta']['conteudo']) && isset($frequencia->original['Resposta']['conteudo']->error) )
            {
                return  $frequencia;
            }

            $servico = Servico::find($idServico);
            $dadosAnteriores = $this->model->regraHistorico($idServico, null, $obterDadosAnteriores = 1, null);
            $dadosAnteriores = (Object) $dadosAnteriores;

            $frequenciaStore = $this->storeTrait($frequencia);

            $sensibilizar = $frequencia->sensibilizado;

            $responseFrequencia = $frequenciaStore->original['Resposta']['conteudo'];

            $regraSaldo = $this->model->regraSaldo($servico->nr_min_prestados_servico, $request->dataHoraEntrada,  $request->dataHoraSaida, null);

            //cria o array apartir do indice e atualiza o saldo
            $saldo = [
                     'nr_min_prestados_servico'      => $regraSaldo,
                     'nr_min_sensibilizados_servico' => $servico->nr_min_sensibilizados_servico + $sensibilizar,
                    ];
        }
        //Retornar erro em caso de não ser mensal ou diario
        else
        {
            $error['message'] = "Não foi possivel identificar o tipo de frequencia informada(Mensal/Semanal)";
            $error['error']   = true;

            return  $this->createResponse($error, 422);
        }
        //grava no historico de serviços e atualiza o saldo
        if(! isset($responseFrequencia->error) )
        {
            //atualiza o saldo
            Servico::where('PK_SERVICO', $idServico)->update($saldo);
            
            $dadosAtualizados = $this->model->regraHistorico($idServico, $dadosAnteriores, $atualizarDados = 2, $responseFrequencia->id);
            
            if(isset($dadosAtualizados->error))
            {
                return $this->createResponse($historico, 404);
            }
        }

        return $frequenciaStore;

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

        if( isset($responseValidate->error))
        {
            return $validate;
        }

        //obtem o id da servico e o tipo de frequencia
        $idServico      = $request->servico;
        $tipoFrequencia = $request->tipo;

        //Verifica se o serviço esta ativo
        $regraAtivo = (Object) $this->model->regraAtivo($idServico);

        if( isset($regraAtivo->error) )
        {
            return  $this->createResponse($regraAtivo, 422);
        }
        //caso a frequencia seja mensal
        if($request->has('total') && $request->has('dataHoraEntrada'))
        {
            $frequencia = Frequencia::find($id);
            $servico = Servico::find($idServico);
            $dadosAnteriores = $this->model->regraHistorico($idServico, null, $obterDadosAnteriores = 1, null);
            $dadosAnteriores = (Object) $dadosAnteriores;

            /*cria o array contendo os dados anteriores de minutos prestados e sensibilizados do id da frequencia passada,
              converte o total da frequencia gravada no DB p/minutos, e realiza os calculos para atualizar o Servico.
            */
            $frequenciaAnterior =
            [
                'nr_min_prestados_servico'      => ($dadosAnteriores->nr_min_prestados_servico) - ($frequencia->nr_total_frequencia),
                'nr_min_sensibilizados_servico' => ($dadosAnteriores->nr_min_sensibilizados_servico) - ($frequencia->nr_sensibilizado_frequencia),
            ];
            //Atualiza os minutos prestados e sensibilizados de acordo com os dados Anteriores da frequencia
            Servico::where('PK_SERVICO', $idServico)->update($frequenciaAnterior);

            $regraTipo = (Object) $this->model->regraTipoFrequencia($idServico, $tipoFrequencia, $request->dataHoraEntrada);

            if( isset($regraTipo->error) )
            {
                return  $this->createResponse($regraTipo, 422);
            }

            $frequencia = $this->frequenciaMensal($request);

            //converte o total informado no request para minutos para ser gravado no BD
            $request->merge(['total' =>  $frequencia->total * 60]);

            if( isset($frequencia->original['Resposta']['conteudo']) && isset($frequencia->original['Resposta']['conteudo']->error) )
            {
                return  $frequencia;
            }

            $frequenciaUpdate =  $this->updateTrait($frequencia, $id);

            $sensibilizar = $frequencia->sensibilizado;

            $responseFrequencia = $frequenciaUpdate->original['Resposta']['conteudo'];

            $servico = Servico::find($idServico);
            //atualiza o saldo
            $regraSaldo = $this->model->regraSaldo($servico->nr_min_prestados_servico, null,  null, $frequencia->total);

            //cria o array apartir do indice e atualiza o saldo
            $saldo = [
                     'nr_min_prestados_servico'      => $regraSaldo,
                     'nr_min_sensibilizados_servico' => $servico->nr_min_sensibilizados_servico + $sensibilizar,
                    ];
        }
        //caso a frequencia seja diaria
        else if($request->has('dataHoraEntrada') && $request->has('dataHoraSaida'))
        {
            $frequencia = Frequencia::find($id);
            $servico = Servico::find($idServico);
            $dadosAnteriores = $this->model->regraHistorico($idServico, null, $obterDadosAnteriores = 1, null);
            $dadosAnteriores = (Object) $dadosAnteriores;

            /*cria o array contendo os dados anteriores de minutos prestados e sensibilizados do id da frequencia passada,
              converte o total da frequencia gravada no DB p/minutos, e realiza os calculos para atualizar o Servico.
            */
            $frequenciaAnterior =
            [
                'nr_min_prestados_servico'      => ($dadosAnteriores->nr_min_prestados_servico) - ($frequencia->nr_total_frequencia),
                'nr_min_sensibilizados_servico' => ($dadosAnteriores->nr_min_sensibilizados_servico) - ($frequencia->nr_sensibilizado_frequencia),
            ];
            //Atualiza os minutos prestados e sensibilizados de acordo com os dados Anteriores da frequencia
            Servico::where('PK_SERVICO', $idServico)->update($frequenciaAnterior);

            $regraTipo = (Object) $this->model->regraTipoFrequencia($idServico, $tipoFrequencia, $request->dataHoraEntrada);

            if( isset($regraTipo->error) )
            {
                return  $this->createResponse($regraTipo, 422);
            }

            $frequencia = (Object) $this->frequenciaDiaria($request);


            if( isset($frequencia->original['Resposta']['conteudo']) && isset($frequencia->original['Resposta']['conteudo']->error) )
            {
                return  $frequencia;
            }

            $frequenciaUpdate = $this->updateTrait($frequencia, $id);

            $sensibilizar = $frequencia->sensibilizado;

            $responseFrequencia = $frequenciaUpdate->original['Resposta']['conteudo'];

            $servico = Servico::find($idServico);

            $regraSaldo = $this->model->regraSaldo($servico->nr_min_prestados_servico, $request->dataHoraEntrada,  $request->dataHoraSaida, null);

            //cria o array apartir do indice e atualiza o saldo
            $saldo = [
                     'nr_min_prestados_servico'      => $regraSaldo,
                     'nr_min_sensibilizados_servico' => $servico->nr_min_sensibilizados_servico + $sensibilizar,
                    ];
        }
        //Retornar erro em caso de não ser mensal ou diario
        else
        {
            $error['message'] = "Não foi possivel identificar o tipo de frequencia informada(Mensal/Semanal)";
            $error['error']   = true;

            return  $this->createResponse($error, 422);
        }
        //grava no historico de serviços e atualiza o saldo
        if(! isset($responseFrequencia->error) )
        {
            //atualiza o saldo
            Servico::where('PK_SERVICO', $idServico)->update($saldo);

            //atualiza historico
            $dadosAtualizados = $this->model->regraHistorico($idServico, $dadosAnteriores, $atualizarDados = 2, $responseFrequencia->id);
            
            if(isset($dadosAtualizados->error))
            {
                return $this->createResponse($historico, 404);
            }

        }

        return $frequenciaUpdate;
    }


    /**
     * <b>destroy</b> Método responsável em receber a requisição do tipo DELETE e encaminhar a mesma para o metodo index da ApiControllerTrait
     *  @param  int  $id
     *  @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $error['message'] = "Ação não permitida. Para excluir uma frequência deverá ser informado um motivo.";
        $error['error']   = true;

        return  $this->createResponse($error, 405);

    }


    /**
     * <b>excluir</b> Método responsável em receber a requisição do tipo POST (com o campo motivoExclusao preenchido e com o id do registro que será excluido logicamente)
     * atualizar o valor do campo ds_exclusao_frequencia e após atualizar excluir o mesmo.
     *
     * @param \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */

    public function excluir(Request $request, $id)
    {

        $query =  $this->model->find($id);

        if(! is_null($query))
        {
            //exibi o resultado da consulta de acordo com os nomes do "mundo externo"
            $query =  (Object) $this->columnsShow($query);
            //obtem o id da servico
            $idServico = $query->servico;
            //inicialmente a requisição so recebe o campo motivoExclusão esses outros são criados apartir da consulta
            $request->request->add([
                'servico'             => $query->servico,
                'tipo'                => $query->tipo,
                'dataHoraEntrada'     => $query->dataHoraEntrada,
                'dataHoraSaida'       => $query->dataHoraSaida,
                'total'               => $query->total,
                'atividadesRealizada' => $query->atividadesRealizada,
            ]);

            $servico = Servico::find($idServico);
            $dadosAnteriores = $this->model->regraHistorico($idServico, null, $obterDadosAnteriores = 1, null);
            $dadosAnteriores = (Object) $dadosAnteriores;

            //subtraindo o total cancelado para atualizar
            $servico->nr_min_prestados_servico      = ($dadosAnteriores->nr_min_prestados_servico) - $query->total;
            $servico->nr_min_sensibilizados_servico = ($dadosAnteriores->nr_min_sensibilizados_servico) - $query->sensibilizado;
            $data = $servico->toArray();

            //atualizando o serviço subtraindo o valor da frequência excluida
            $servico->update($data);

            $delete = $this->destroyTrait($id);

            //atualiza historico
            $dadosAtualizados = $this->model->regraHistorico($idServico, $dadosAnteriores, $atualizarDados = 2, $id);
            
            if(isset($dadosAtualizados->error))
            {
                return $this->createResponse($historico, 404);
            }

            return $delete;

        }

        $error['message'] = "A Frequência informada não existe !";
        $error['error']   = true;

        return $this->createResponse($error, 422);

    }

    /**
     * <b>frequenciaDiaria</b> Método responsável em receber os dados de cadastro de uma frequência diaria e realizar as validações necessárias
     * de acordo com as regras de negócios para este tipo de frequência.
     *  @param \Illuminate\Http\Request  $request (Recebe os seguintes dados: servico, tipo, atividadesRealizada, total, data)
     *  @param bool $update (recebe um valor boleano true, quando se trata de atualização de dados)
     *
     *  @return \Illuminate\Http\Request ou $error
     *
     */
    protected function frequenciaDiaria(Request $request, $update = null)
    {
        //faz o replace das datas informadas
        $request->dataHoraEntrada = $this->formatData($request->dataHoraEntrada);
        $request->dataHoraSaida   = $this->formatData($request->dataHoraSaida);

        $regraFrequencia = (Object) $this->model->regraFrequencia($request->dataHoraEntrada, $request->dataHoraSaida);

        if( isset($regraFrequencia->error) )
        {
          return $this->createResponse($regraFrequencia, 422);
        }

        //atribui o valor retornado da regra de frequencia já convertido e padronizado
        $request->merge(['dataHoraEntrada' =>  $regraFrequencia->entrada]);
        $request->merge(['dataHoraSaida'   =>  $regraFrequencia->saida]);
        $request->request->add(['total'    =>  $regraFrequencia->total]);

        //*****Deverá ser avaliada a criação de regras para evitar choque de horarios****
        //if(!is_null($update) && is_bool($update) == true)
        // {
        //
        //     $regraBatida = (Object) $this->model->regraBatida($request->servico, $request->dataHoraEntrada, $request->dataHoraSaida);
        //
        // }
        // else
        // {
        //     $regraBatida = (Object) $this->model->regraBatida($request->servico, $request->dataHoraEntrada);
        // }
        //
        // if( isset($regraBatida->error))
        // {
        //     return $this->createResponse($regraBatida, 422);
        // }

        $regraLimite = (Object) $this->model->regraLimite($request->servico, $request->tipo, $request->dataHoraEntrada, $request->dataHoraSaida);

        if( isset($regraLimite->error) )
        {
            return $this->createResponse($regraLimite, 422);
        }


        $request->request->add(['sensibilizado' => $regraLimite->minSensibilizados]);

        return $request;



    }

    /**
     * <b>frequenciaMensal</b> Método responsável em receber os dados de cadastro de uma frequência mensal e realizar as validações necessárias
     * de acordo com as regras de negócios para este tipo de frequência.
     *  @param \Illuminate\Http\Request  $request (Recebe os seguintes dados: servico, tipo, dataHoraEntrada, dataHoraSaida)
     *
     *  @return \Illuminate\Http\Request ou $error
     */
    protected function frequenciaMensal(Request $request)
    {

        $regraLimite = (Object) $this->model->regraLimite($request->servico, $request->tipo, null, null, $request->total, $request->dataHoraEntrada);

        if( isset($regraLimite->error) )
        {
            return $this->createResponse($regraLimite, 422);
        }

        $request->request->add(['sensibilizado' => $regraLimite->minSensibilizados]);

        return $request;
    }


    /**
     * <b>excluir</b> Método responsável retornar os registros de determinado ID em determinado ANO e MÊS
     *
     *
     * @param \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  int  $ano
     * @param  int  $mes
     * @return \Illuminate\Http\Response
    */

    public function showByDate(Request $request, $id, $ano, $mes, $statusCode = null)
    {
        $mes2digitos = strlen($mes)>1 ? $mes: "0".$mes;
        $query = DB::select("SELECT * FROM SIGMP_SERVICO_FREQUENCIA WHERE FK_PK_SERVICO={$id} AND TO_CHAR(hr_entrada_frequencia,'YYYYMM') = '{$ano}{$mes2digitos}'");
        $frequencias = (object) Frequencia::hydrate($query);
        $frequencias = $this->arrayPaginator($frequencias, $request);
        $class = $this->model->collection;
        $result = $class($frequencias);

        return $this->createResponse($result);

      }


    /*
    * Verificar em caso que retorne mais de 15 elementos, as páginas estão fixas?
    * ref.: https://stackoverflow.com/questions/44090392/how-to-use-pagination-with-laravel-dbselect-query
    */
      public function arrayPaginator($colecao, $request)
      {

          $page = \Illuminate\Support\Facades\Input::get('page', 1);
          $perPage = 15;
          $offset = ($page * $perPage) - $perPage;

          return new \Illuminate\Pagination\LengthAwarePaginator(array_slice($colecao->all(), $offset, $perPage, true), count($colecao->all()), $perPage, $page,
              ['path' => $request->url(), 'query' => $request->query()]);
      }

}
