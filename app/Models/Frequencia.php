<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Servico;

use App\Models\TipoFrequencia;
use App\HelpersTrait;

use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class Frequencia extends Model
{
    use SoftDeletes, HelpersTrait;

    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const CREATED_AT = 'dt_cadastro_frequencia';

    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const UPDATED_AT = 'dt_atualizacao_frequencia';

    /**
     * <b>FREQ_DIARIO</b> Representa um valor da coluna nm_tipo_frequencia da tabela TipoFrequencia
     */
    const FREQ_DIARIO = 'Diária'; // TODO: deveria comparar com ID e não com NOME, ou pelo menos pegar o valor do BD

    /**
     * <b>FREQ_MENSAL</b> Representa um valor da coluna nm_tipo_frequencia da tabela TipoFrequencia
     */
    const FREQ_MENSAL  = 'Mensal'; // TODO: deveria comparar com ID e não com NOME, ou pelo menos pegar o valor do BD


    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
    */
    const DELETED_AT = 'dt_exclusao_frequencia';

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
    */
    protected $primaryKey = "pk_frequencia";

    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
    */
    protected $dates = ['dt_cadastro_frequencia', 'dt_atualizacao_frequencia', 'dt_exclusao_frequencia', 'hr_entrada_frequencia', 'hr_saida_frequencia'];

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *
    */
    protected $fillable=[
                          'fk_pk_servico',
                          'fk_pk_tipo_frequencia',
                          'hr_entrada_frequencia',
                          'nr_total_frequencia',
                          'nr_sensibilizado_frequencia',
                          'ds_atividade_frequencia',
                          'ds_observacao_frequencia',
                          'hr_saida_frequencia',
                          'ds_exclusao_frequencia',

                        ];


    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    public $table = "sigmp_servico_frequencia";

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'fk_pk_servico'            => 'bail|required|numeric',
        'fk_pk_tipo_frequencia'    => 'bail|required|numeric|min:1',
        'hr_entrada_frequencia'    => 'bail|required|date',
        'hr_saida_frequencia'      => 'bail|required|date',
        'ds_atividade_frequencia'  => 'bail|nullable|min:5|max:255',
        'ds_observacao_frequencia' => 'bail|nullable|min:5|max:255',
        'ds_exclusao_frequencia'   => 'bail|nullable|min:5|max:255',
        'dt_cadastro_frequencia'   => 'bail|date',
        'dt_atualizacao_frequencia'=> 'bail|date',
        'dt_exclusao_frequencia'   => 'bail|date',

    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'fk_pk_servico.required'          => 'Frequência: O campo servico é obrigatório!',
        'fk_pk_servico.numeric'           => 'Frequência: O campo servico é do tipo númerico !',
        'fk_pk_tipo_frequencia.required'  => 'Frequência: O campo tipo é obrigatório!',
        'fk_pk_tipo_frequencia.numeric'   => 'Frequência: O campo tipo é do tipo númerico !',
        'hr_entrada_frequencia.required'  => 'O campo dataHoraEntrada é obrigatório !',
        'hr_saida_frequencia.required'    => 'O campo dataHoraSaida é obrigatório !',
        'ds_atividade_frequencia.min'     => 'O campo atividadesRealizada deve conter pelo menos 5 caracteres!',
        'ds_atividade_frequencia.max'     => 'O campo atividadesRealizada deve conter até 255 caracteres!',
        'ds_observacao_frequencia.min'    => 'O campo observacoes deve conter pelo menos 5 caracteres!',
        'ds_observacao_frequencia.max'    => 'O campo observacoes deve conter até 255 caracteres!',
        'ds_exclusao_frequencia.min'      => 'O campo motivoExclusao deve conter pelo menos 5 caracteres!',
        'ds_exclusao_frequencia.max'      => 'O campo motivoExclusao deve conter até 255 caracteres!',


    ];


    /**
     * <b>hidden</b> Atributo responsável em esconder colunas que não deverão ser retornadas em uma requisição
    */
    protected $hidden  = [
        'rn',
    ];

    /**
     *<b>collection</b> Atributo responsável em informar o namespace e o arquivo do resorce
     * O mesmo é utilizado em forma de facade.
     * OBS: Responsável em retornar uma coleção com os alias(apelido) atribuitos para cada coluna.
     * Mais informações em https://laravel.com/docs/5.5/eloquent-resources
    */
    public $collection = "\App\Http\Resources\FrequenciaResource::collection";

    /**
     * <b>resource</b>
    */
    public $resource = "\App\Http\Resources\FrequenciaResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
    */
    public $map = [
        'id'                  => 'pk_frequencia',
        'servico'             => 'fk_pk_servico',
        'tipo'                => 'fk_pk_tipo_frequencia',
        'dataHoraEntrada'     => 'hr_entrada_frequencia',
        'dataHoraSaida'       => 'hr_saida_frequencia',
        'total'               => 'nr_total_frequencia',
        'sensibilizado'       => 'nr_sensibilizado_frequencia',
        'atividadesRealizada' => 'ds_atividade_frequencia',
        'observacoes'         => 'ds_observacao_frequencia',
        'motivoExclusao'      => 'ds_exclusao_frequencia',
        'data_cadatro'        => 'dt_cadastro_frequencia',
        'data_atualizacao'    => 'dt_atualizacao_frequencia',
        'data_exclusao'       => 'dt_exclusao_frequencia',
    ];

    /**
     * <b>getPrimaryKey</b> Método responsável em retornar o nome da primaryKey.
     * OBS: Não é recomendado que este atributo seja publico, por isso foi realizado o encapsulamento
    */

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * <b>servico</b> Método responsável em definir o relacionamento entre as Models de Frequencia e Servico e suas
     * respectivas tabelas.
     */
    public function servico()
    {
        return $this->belongsTo(Servico::class, 'fk_pk_servico', 'pk_servico');
    }

    /**
     * <b>tipoFrequencia</b> Método responsável em definir o relacionamento entre as Models de Frequencia e TipoFrequencia e suas
     * respectivas tabelas.
     */
    public function tipoFrequencia()
    {
        return $this->belongsTo(TipoFrequencia::class, 'fk_pk_tipo_frequencia', 'pk_tipo_frequencia');
    }




    ///////////////////////////////////////////////////////////////////
    ///////////////////// REGRAS DE NEGOCIO ///////////////////////////
    ///////////////////////////////////////////////////////////////////


     /**
     * <b>regraAtivo</b> Método responsável em verificar se o pena informado se encontra ativo
     * @param $id   (id servico)
     * @return true (caso o pena exista) ou $error
     */
    public function regraAtivo($idServico)
    {
        $query = Servico::find($idServico);

        if(! is_null($query))
        {
            $count = $query->whereRaw("PK_SERVICO={$idServico} AND DS_ATIVO_SERVICO= 1")->count();

            if($count > 0)
            {
                return true;
            }

            $error['message'] = "O Servico informado não esta ativo. Ação não permitida !";
            $error['error']   = true;

            return $error;

        }

        $error['message'] = "Falha no processamento do Serviço.";
        $error['error']   = true;

        return $error;


    }


    /**
     * <b>regraTipoFrequencia</b> Método responsável em verficiar se a frequencia que ira ser lançada, já foi iniciada anteriomente por um outro tipo.
     * Exemplo: Se um usuário lançar uma frequência do tipo diária para o mes de 04-2018 e um outro tentar lancar a frequencia para este mesmo mês como mensal
     * O sistema exibe uma mensagem de erro.
     * @param int  $idServico (Id do serviço)
     * @param int  $tipoFrequencia (Id do tipo da frequencia que pode ser diário ou mensal)
     * @param date $referencia (data para referencia do mês)
     */
    public function regraTipoFrequencia($idServico, $tipoFrequencia, $referencia)
    {
        $referencia = Carbon::parse($referencia)->format('Y-m');

        $queryFrequencia = $this->whereRaw("TO_CHAR(HR_ENTRADA_FREQUENCIA,'yyyy-mm') LIKE '%$referencia%' AND FK_PK_SERVICO={$idServico}")->orderBy('pk_frequencia', 'ASC');

        $count = $queryFrequencia->count();

        if($count >= 1)
        {

           $queryFrequencia = (Object) $queryFrequencia->limit(1)->get();
           $tipo = $queryFrequencia[0]->fk_pk_tipo_frequencia;
           $ultimaFrequencia = $queryFrequencia[0]->pk_frequencia;

           $nomeUltimaFrequencia = $this->find($ultimaFrequencia)->tipoFrequencia()->get();
           $nomeUltimaFrequencia = trim($nomeUltimaFrequencia[0]->nm_tipo_frequencia);
           $nomeFrequenciaAtual  = TipoFrequencia::find($tipoFrequencia);
           $nomeFrequenciaAtual  = trim($nomeFrequenciaAtual->nm_tipo_frequencia);

           $referencia = Carbon::parse($referencia)->format('m/Y');

           if($tipo != $tipoFrequencia)
            {
                $error['message'] = "Ação não permitida: lançar frequência como {$nomeFrequenciaAtual} (esta frequencia do mês {$referencia} se iniciou sendo lançada como {$nomeUltimaFrequencia}) !";
                $error['error']   = true;

                return $error;
            }

            return true;
        }
    }



    /**
     * <b>regraFrequencia</b> Metodo responsável em realizar verificações na entrada e na saida informada na frequencia
     * REGRA 1- A data e hora de entrada não pode ser maior do que a data e hora de saida
     * REGRA 2- A data e hora de entrada e a data e hora de saida não podem ser iguais
     * REGRA 3- Entre a data e hora de entrada e a data e hora de saida deve ter pelo menos 1 minuto, caso contrario a batida não sera realizada
     * @param  datetime  $entrada (no seguinte formato 29-08-2018 19:06, utilizado quando a frequencia for lançada de forma diaria)
     * @param  datetime  $saida   (no seguinte formato 29-08-2018 19:06, utilizado quando a frequencia for lançada de forma diaria)
     * @param  int       $totalHoras (recebe o numero de horas realizado no mes pelo apenado, utilizado quando a frequencia for lançada de forma mensal)
     * @param date       $data (recebe uma data, utilizado quando a frequencia for lançada de forma mensal)
     * @return $result ou $error
    */
    public function regraFrequencia($entrada = null, $saida = null, $totalHoras = null, $data = null)
    {
        //Verificar antes se a data é vazia é se é valida;

        if( is_null($totalHoras) && is_null($entrada))
        {
            $error['message'] = "A data e hora de entrada e/ou saida, ou total de horas não foram informadas ";
            $error['error']   = true;

            return $error;
        }
        //diario
       if( isset($entrada) && isset ($saida) )
       {
            $dateTimeEntrada = Carbon::parse($entrada);
            $dateTimeSaida   = Carbon::parse($saida);

            if($dateTimeEntrada > $dateTimeSaida || $dateTimeEntrada->equalTo($dateTimeSaida))
            {

                $error['message'] = "A data e hora de entrada e maior ou igual a de saida";
                $error['error']   = true;

                return $error;
            }
            elseif($dateTimeEntrada->diffInMinutes($dateTimeSaida) < 1)
            {

                $error['message'] = "Entre a entrada e a saida deve ter o intervalo de pelo menos 1 minuto";
                $error['error']   = true;

                return $error;
            }
            else
            {
                $totalMinutos    = $dateTimeEntrada->diffInMinutes($dateTimeSaida);
                $dateTimeEntrada = $dateTimeEntrada->toDateTimeString();
                $dateTimeSaida   = $dateTimeSaida->toDateTimeString();


                $result['entrada'] = $dateTimeEntrada;
                $result['saida']   = $dateTimeSaida;
                $result['total']   = $totalMinutos;


                return $result;
            }
       }else if(isset($totalHoras) && isset ($data))
        {
            $result['total']   = $totalHoras;
            //Adicionar horas 00:00:00
            $result['entrada'] = $data;
            $result['saida']   = $data;

            return $result ;
        }
        else
        {
            $error['message'] = "Não foi informado uma frequencia diaria e nen mensal para validação da regra de frequencia";
            $error['error']   = true;

            return $error;
        }

        //Carbon::setToStringFormat('Y-m-d H:i:s');
        //date('d/m/Y H:i', strtotime($empresa_date));
        //$dateTimeEntrada = Carbon::parse($entrada);//->createFromFormat('Y-m-d H:i:s', $entrada);
        //$dateTimeEntrada = Carbon::createFromFormat('Y-m-d H:i:s', $entrada);
        /*$dateTimeSaida   = Carbon::parse($saida);
        $timeEntrada = $dateTimeEntrada->toTimeString();
        $timeSaida   = $dateTimeSaida->toTimeString();*/

           /*$dateTimeEntrada->diffInMinutes($dateTimeSaida);
            $dateTimeEntrada->diffInDays($dateTimeSaida);
            $dateTimeSaida->diffInHours($dateTimeEntrada)
            $dateTimeEntrada->diffInHours($dateTimeSaida);
            $dateTimeEntrada->equalTo($dateTimeSaida)
            $dateTimeEntrada->diff($dateTimeSaida)->format('%H:%i:%s');*/
    }


    /**
     * <b>regraSaldo</b> Metodo responsável em pegar o saldo anterior de horas prestadas e atualizar o seu valor
     * @param datetime  $entrada (no seguinte formato 29-08-2018 19:06)
     * @param datetime  $saida   (no seguinte formato 29-08-2018 19:06)
     * @param int anterior (valor já convertido para minutos )
     * @return $total
     */
    public function regraSaldo($anterior, $entrada = null, $saida = null, $totalHoras = null)
    {
        if( isset($entrada) && isset($saida))
        {
            $dateTimeEntrada = Carbon::parse($entrada);
            $dateTimeSaida   = Carbon::parse($saida);
            $total = $dateTimeEntrada->diffInMinutes($dateTimeSaida);
        }
        else
        {
            $total = $totalHoras ;

        }

        $total = $total + $anterior;

        return $total;

    }


    /**
     * <b>regraBatida</b> Metodo responsável em verificar se a hora da ultima batida de entrada e maior do que o da ultima saida
     * @param $id      (ID do serviço)
     * @param $entrada (Hora da entrada)
     * @param $saida  (Esse parametro deve ser informado como true no caso de uma atualização de registro de frequencia)
     * @return true ou $error
     *
     */
    public function regraBatida($id, $entrada, $saida = null)
    {

        $dateEntrada = Carbon::parse($entrada)->toDateString();

        $saida = ! is_null($saida) ? $saida =  Carbon::parse($saida): $saida;

        $query = $this->whereRaw("TO_CHAR(HR_ENTRADA_FREQUENCIA,'yyyy-mm-dd') LIKE '%$dateEntrada%' AND FK_PK_SERVICO={$id}")->orderBy('pk_frequencia', 'DESC');

        $count = $query->count();

        if($count > 0)
        {

            $limit = (Object) $query->limit(1)->get();

            $id = $limit[0]->pk_frequencia;

            $ultimaSaida = $limit[0]->hr_saida_frequencia;

            $dateEntrada = Carbon::parse($entrada);

            if( $dateEntrada > $ultimaSaida || ! is_null($saida) && $dateEntrada < $ultimaSaida && $saida > $dateEntrada)
            {
                return true;
            }

            $error['message'] = "O horario da ultima saida informada e menor ou igual o da entrada atual";
            $error['error']   = true;

            return $error;
        }

        return true;

    }

    /**
     * <b>regraSoma</b> Realiza a soma das horas apartir de uma referencia recebida (M/Y)
     * @param $mesReferencia (Mes e ano)
     */
    public function regraSoma($mesReferencia, $idServico)
    {
        $referencia = Carbon::parse($mesReferencia)->format('Y-m');

        $query = $this->whereRaw("TO_CHAR(HR_ENTRADA_FREQUENCIA,'yyyy-mm') LIKE '%$referencia%' AND FK_PK_SERVICO={$idServico}")->orderBy('pk_frequencia', 'ASC');

        $count = $query->count();

        $total = 0;

        if($count > 1)
        {
            foreach($query->get() as $batida)
            {
               // echo $batida->pk_frequencia;
                $totalDia = Carbon::parse($batida->hr_entrada_frequencia);
                $total += $totalDia->diffInHours($batida->hr_saida_frequencia);

            }

            return  $total;
        }

        $error['message'] = "Não existe frequencia para a referencia informada !";
        $error['error']   = true;

        return $error;


    }



    /**
     * <b>regraLimite</b> Método responsável em verificar qual é o tipo de frequencia e o tipo de serviço e de acordo
     * com os mesmos encaminhar para os metodos responsáveis em realizar as validações.
     *
     * @param $idServico ($id do serviço que ira lançar a frequência)
     * @param $idTipo    ($id do tipo de frequência)
     * @param $entrada   (data e hora de entrada)
     * @param $saida     (data e hora de saida)
     *
     */
    public function regraLimite($idServico, $idTipo, $entrada = null, $saida = null, $totalHoras = null, $data = null)
    {
        $queryServico = Servico::find($idServico);
        $totalInformado = 0;

        if(! is_null($queryServico))
        {
            //Caso usuario tenha passado a hora de entrada e hr de saida
            if(! is_null($entrada) && ! is_null($saida))
            {
                $dateTimeEntrada = Carbon::parse($entrada);
                $dateTimeSaida   = Carbon::parse($saida);
                $totalInformado = $dateTimeEntrada->diffInMinutes($dateTimeSaida);
            }

            //Caso usuario tenha passado somente total de horas
            if(! is_null($totalHoras))
            {
                $totalInformado = $totalHoras * 60;
            }

            //obtem os nomes dos tipos de servicos
            $servicoSemanal = Servico::SERV_SEMANAL;
            $servicoMensal  = Servico::SERV_MENSAL;

            //obtem o tipo de servico referente a frequencia em questao
            $tipoServico = $queryServico->tipoServico()->get();
            $tipoServico = trim($tipoServico[0]->nm_tipo_servico);

            //obtem os nomes dos tipos de frequencia
            $frequenciaDiario = self::FREQ_DIARIO;
            $frequenciaMensal = self::FREQ_MENSAL;

            //obtem o tipo de frequencia referente a frequencia em questao
            $queryTipo      = TipoFrequencia::find($idTipo);
            $tipoFrequencia = trim($queryTipo->nm_tipo_frequencia);

            //Obtem o limite maximo para o servico e converte para minutos
            //$limiteServico = $queryServico->nr_max_hrs_servico * 60;


            if($tipoFrequencia == $frequenciaMensal && $tipoServico == $servicoSemanal)
            {
                $error['message'] = "Não permitido inserir frequencia. Limite de serviço semanal, lançamento permitido apenas como diário !";
                $error['error']   = true;

                return $error;
            }

            if($tipoFrequencia == $frequenciaDiario &&  $tipoServico == $servicoSemanal)
            {
                $semanal = (Object) $this->regraSemanal($idServico, $entrada, $saida);
                if(! isset($semanal->error))
                {
                    $semanal   = $semanal->scalar;
                    $sensibilizar = $this->regraHorasSensibilizadas($idServico, $semanal, $totalInformado);

                    return $sensibilizar;

                }

                return $semanal;

            }

            if($tipoFrequencia == $frequenciaDiario && $tipoServico == $servicoMensal)
            {
                //somar tudo, converter para minutos os limites e os realizado e sensibilizar ate o limite
                $mensal = (Object) $this->regraMensal($idServico, $entrada, $saida);
                
                if(! isset($mensal->error))
                {
                    $mensal = $mensal->scalar;
                    $sensibilizar = $this->regraHorasSensibilizadas($idServico, $mensal, $totalInformado);

                    return $sensibilizar;

                }

                return $mensal;


            }

            if($tipoFrequencia == $frequenciaMensal  && $tipoServico == $servicoMensal)
            {

                //somar tudo, converter para minutos os limites e os realizado e sensibilizar ate o limite
                $mensal = (Object) $this->regraMensal($idServico, null, null, $totalHoras, $data);
                
                if(! isset($mensal->error))
                {
                    $mensal = $mensal->scalar;
                    $sensibilizar = $this->regraHorasSensibilizadas($idServico, $mensal, $totalInformado);

                    return $sensibilizar;

                }

                return $mensal;
            }

        }

        $error['message'] = "Falha no processamento do Serviço.";
        $error['error']   = true;

        return $error;

    }

    /**
     * <b>regraHorasSensibilizadas</b> Método responsável em verificar se o valor a ser sensibilizado é maior que o limite,
     * Caso o mesmo não seja maior que o limite os minutosSensibilizados é igual aos minutosRealizados, caso contrario o mesmo poderá receber
     * apenas um valor permitido exemplo: realizado = 20 limite = 10 o mesmo receberá o limite, e em ultimo caso os minutos sensibilizado poderá
     * receber 0 (caso o mesmo já tenha realizado até o limite permitido.
     *
     * OBS: Lembrando que o limite é cadastrado no serviço e pode ser Semanal ou Mensal (o mesmo esta gravado como horas no banco de dados)
     *
     * @param int $idServico (id do serviço que ira lançar a frequência)
     * @param int $realizado (total de minutos realizados. OBS: Não leva em consideração o dia que irá ser lançado)
     * @param int $diario    (total em minutos do dia que irá ser lançado)
     * @param int $limite    (limite em horas, permitido. OBS: o mesmo pode ser: semanal ou mensal)
     * @return $result ou $error
     *
     */                                    

     // $diario => $qtdHorasInformadaEmMinutos
     // $limite => $qtdTotalDoServicoEmMinutos
     // $sensibilizado => qtdSensibilizadosEmMinutos
     // $realizado =>
    public function regraHorasSensibilizadas($idServico, $totalMinutosCadatradosEmFrequencia, $qtdHorasInformadaEmMinutos)
    {
        $query = Servico::find($idServico);
        if(! is_null($query))
        {
            //Obtem o limite maximo para o servico e converte para minutos
            $limiteMaxServicoEmMinutos = $query->nr_max_hrs_servico * 60;
            $qtdSensibilizadosEmMinutos = $query->nr_min_sensibilizados_servico;
            $qtdTotalDoServicoEmMinutos = $query->nr_hrs_servico * 60;
            //if( ( $qtdHorasInformadaEmMinutos + $totalMinutosCadatradosEmFrequencia ) <= $limiteMaxServicoEmMinutos)
            if( $qtdHorasInformadaEmMinutos <= $limiteMaxServicoEmMinutos )
            {
                if($qtdTotalDoServicoEmMinutos >= ($qtdHorasInformadaEmMinutos + $qtdSensibilizadosEmMinutos))
                {
                    $result['minSensibilizados'] = $qtdHorasInformadaEmMinutos ;
                }
                else
                {
                    $ultrapassou = ( $qtdSensibilizadosEmMinutos + $qtdHorasInformadaEmMinutos ) - $qtdTotalDoServicoEmMinutos ;
                    $permitido = $qtdHorasInformadaEmMinutos - $ultrapassou ;
                    if($permitido > $limiteMaxServicoEmMinutos)
                    {
                        $valorUltrapassadoDoLimiteMax = $permitido - $limiteMaxServicoEmMinutos ;
                        $valorPermitidoEmRelaçãoAoLimiteMax = $permitido - $valorUltrapassadoDoLimiteMax ;
                        $result['minSensibilizados'] = $valorPermitidoEmRelaçãoAoLimiteMax;
                    }
                    else
                    {
                        $result['minSensibilizados'] = $permitido;
                    }
                }
            }
            //else if( ( $qtdHorasInformadaEmMinutos + $totalMinutosCadatradosEmFrequencia ) > $limiteMaxServicoEmMinutos)
            else if( $qtdHorasInformadaEmMinutos  > $limiteMaxServicoEmMinutos )
            {
                if($qtdTotalDoServicoEmMinutos >= ($qtdSensibilizadosEmMinutos + $qtdHorasInformadaEmMinutos))
                {
                    //$pretendido = $qtdSensibilizadosEmMinutos + $qtdHorasInformadaEmMinutos;
                    $ultrapassou = $qtdHorasInformadaEmMinutos - $limiteMaxServicoEmMinutos;
                    
                    // obtendo o resultado positivo, caso retorne nr negativo
                    if($ultrapassou < 0)
                    {
                        $ultrapassou = abs($ultrapassou);
                    }

                    $permitido = $qtdHorasInformadaEmMinutos - $ultrapassou;
                    $result['minSensibilizados'] = $permitido ;
                }
                else
                {
                    $ultrapassou = ( $qtdSensibilizadosEmMinutos + $qtdHorasInformadaEmMinutos ) - $qtdTotalDoServicoEmMinutos ;

                    // obtendo o resultado positivo, caso retorne nr negativo
                    if($ultrapassou < 0)
                    {
                        $ultrapassou = $this->abs($ultrapassou);
                    }

                    $permitido = $qtdHorasInformadaEmMinutos - $ultrapassou ;
                        if($permitido > $limiteMaxServicoEmMinutos)
                        {
                            $valorUltrapassadoDoLimiteMax = $permitido - $limiteMaxServicoEmMinutos ;
                            $valorPermitidoEmRelaçãoAoLimiteMax = $permitido - $valorUltrapassadoDoLimiteMax ;
                            $result['minSensibilizados'] = $valorPermitidoEmRelaçãoAoLimiteMax;
                        }
                        else
                        {
                            $result['minSensibilizados'] = $permitido;
                        }
                    
                }
            }
            return $result;
        }

        $error['message'] = "Falha no processamento do Serviço.";
        $error['error']   = true;

        return $error;

    }

    /**
     * <b>regraSemanal</b> Método responsável em verificar se o quantitativo de horas realizadas em um dia extrapola o limite diário de 12 horas
     * O mesmo também é responsavel por obter o quantitativo de minutos realizados em uma semana, para isso o mesmo recebe
     * o id do serviço, uma data e hora de entrada e saida.
     * @param int $idServico (id do serviço que ira lançar a frequência)
     * @param datetime $entrada   (data e hora de entrada)
     * @param datetime $saida     (data e hora de saida)
     * @return $sum
     */
    public function regraSemanal($idServico, $entrada, $saida)
    {
        $dateTimeEntrada = Carbon::parse($entrada);
        $dateTimeSaida   = Carbon::parse($saida);

        $limitDay = $dateTimeEntrada->diffInHours($dateTimeSaida);

         if($limitDay > 12)
         {
            $error['message'] = "Registro não permitido, o mesmo excede o limite de 12 horas diarias";
            $error['error']   = true;

            return $error;
         }

        //pega o inicio e o fim da semana
        $startWeek = $dateTimeEntrada->copy()->startOfWeek();
        $endWeek   = $dateTimeEntrada->copy()->endOfWeek();
        //pega o numero de dias entre o inicio da semana e o horario de batida
        //$days = $dateTimeEntrada->diffInDays($startWeek);
        $dates = [];
        //obtem todas as datas entre o inicio da semana e a batida
        for($date = $startWeek; $date->lte($dateTimeEntrada); $date->addDay())
        {
            $dates[] = $date->format('Y-m-d');
        }
        $result = [];
        //obtem os dados de cada dia e atribui para um array
        for($i=0; $i < count($dates); $i++)
        {
            $param = $dates[$i];
            $query = $this->whereRaw("TO_CHAR(HR_ENTRADA_FREQUENCIA,'yyyy-mm-dd') LIKE '%$param%' AND FK_PK_SERVICO={$idServico}")->orderBy('pk_frequencia', 'ASC');
            $count = $query->count();

            if($count > 0)
            {
                $result[$param] = $query->get()->toArray();
            }
        }
        $sum = 0;
        //faz dois laços o primeiro para obter o dado do dia e o segundo para pegar o seu indice e realizar a soma
        foreach($result as $value)
        {
            for($i=0; $i < count($value); $i++)
            {

                $sum+= $value[$i]['nr_total_frequencia'];
            }

        }
       return $sum;
    }

    /**
     * <b>regraMensal</b> Método responsável em verificar se o quantitativo de horas realizadas em um dia extrapola o limite diário de 12 horas
     * ou o limite de 360 horas mensais (de acordo com o tipo de frequência) O mesmo também é responsavel por obter o quantitativo de minutos realizados em uma semana,
     * para isso o mesmo recebe id do serviço, pode receber data e hora de entrada e saida ou o quantitativo de horas totais realizado em um mês
     * @param int $idServico (id do serviço que ira lançar a frequência)
     * @param datetime  $entrada   (data e hora de entrada)
     * @param datetime $saida     (data e hora de saida)
     * @param int $total     (quantitativo de horas totais realizado em um mês)
     * @return $totalMes ou $error
     *
     */

    public function regraMensal($idServico, $entrada = null, $saida = null, $totalHoras = null, $data = null)
    {
        $queryServico = Servico::find($idServico);

        if(! is_null($queryServico))
        {
            if(! is_null($entrada) && ! is_null($saida))
            {
                $dateTimeEntrada = Carbon::parse($entrada);
                $dateTimeSaida   = Carbon::parse($saida);

                $limitDay = $dateTimeEntrada->diffInHours($dateTimeSaida);

                 if($limitDay > 12)
                 {
                    $error['message'] = "Registro não permitido, o mesmo excede o limite de 12 horas diarias";
                    $error['error']   = true;

                    return $error;
                 }
            }

            if(! is_null($totalHoras) && $totalHoras > 360)
            {
                $error['message'] = "Registro não permitido, o mesmo excede o limite de 360 horas mensais";
                $error['error']   = true;

                return $error;
            }

            $mesReferencia = ! is_null($entrada) ? $entrada : $data;
            $referencia = null;

            if(! is_null($mesReferencia))
            {
                $referencia = Carbon::parse($mesReferencia)->format('Y-m');
            }
            $totalMes = 0;
            
            if(! is_null($referencia))
            {
                $query = $this->whereRaw("TO_CHAR(HR_ENTRADA_FREQUENCIA,'yyyy-mm') LIKE '%$referencia%' AND FK_PK_SERVICO={$idServico}")->orderBy('pk_frequencia', 'ASC');
                $count = $query->count();
                if($count >= 1)
                {
                    foreach($query->get() as $batida)
                    {

                       // echo $batida->pk_frequencia;
                        /*$totalDia = Carbon::parse($batida->hr_entrada_frequencia);
                        $totalMes += $totalDia->diffInMinutes($batida->hr_saida_frequencia);*/
                        $totalMes += $batida->nr_total_frequencia ;
                    }

                    //return  $totalMes;
                }
            }
            return $totalMes * 60;

        }

        $error['message'] = "Falha no processamento do Serviço.";
        $error['error']   = true;

        return $error;

    }

    /**
     * <b>regraHistorico</b> Método responsável realizar a gravação de seu respectivo historico, apartir a criação de uma frequencia.
     * @param $idServico
     * @param $dadosAnteriores
     * @param $tipoDeUso (1 = obter dados anteriores / outro nr qualquer = atualizar o historico)
     * @param $idFrequencia
     * @return $data ou error
    */
    public function regraHistorico($idServico, $dadosAnteriores, $tipoDeUso, $idFrequencia)
    {
        if(!is_null($idServico))
        {
            //Obtendo os dados do servico informado na frequencia
            $servico = Servico::find($idServico);

            //Caso for usado para obter os dados anteriores
            if($tipoDeUso == 1)
            {
                $data = 
                [
                    //Criando o array com os dados anteriores presentes em Servico
                    'nr_min_prestados_servico'      => $servico->nr_min_prestados_servico,
                    'nr_min_sensibilizados_servico' => $servico->nr_min_sensibilizados_servico,
                ];
            }
            //Caso for usado para atualizar o historico
            else
            {
                $minutosPrestadosAnteriores = $dadosAnteriores->nr_min_prestados_servico ;
                $minutosSensibilizadosAnteriores = $dadosAnteriores->nr_min_sensibilizados_servico ;
                //Obtendo os dados após a atualização
                $minutosPrestadosAtualizados = $servico->nr_min_prestados_servico ;
                $minutosSensibilizadosAtualizados = $servico->nr_min_sensibilizados_servico ;
                //Criando o array com os dados já atualizados com a nova frequencia inserida
                $data = [
                    'nr_hrs_anterior'                => $servico->nr_hrs_servico,
                    'nr_min_prestados_anterior'      => $minutosPrestadosAnteriores,
                    'nr_min_hrs_anterior'            => $servico->nr_min_hrs_servico,
                    'nr_max_hrs_anterior'            => $servico->nr_max_hrs_servico,
                    'nr_mes_minimo_anterior'         => $servico->nr_mes_minimo_servico,
                    'nr_min_sensibilizados_anterior' => $minutosSensibilizadosAnteriores,
                    'fk_pk_tipo_servico_anterior'    => $servico->fk_pk_tipo_servico,
                    'fk_pk_entidade_anterior'        => $servico->fk_pk_entidade,
                    'nr_min_prestados_novo'          => $minutosPrestadosAtualizados,
                    'nr_min_sensibilizados_novo'     => $minutosSensibilizadosAtualizados,
                    'ds_id_origem'                   => $idFrequencia,
                    'ds_tipo_origem'                 => 'App\Models\Frequencia',
                ];
                //grava o historico após atualizar o saldo de horas prestadas
                $servico->historicoServicos()->create($data);
            }

            return $data;
        }

        $error['message'] = "A Custas, Multa ou Pecunia informada não existe";
        $error['error']   = true;

        return $error;

    }















}
