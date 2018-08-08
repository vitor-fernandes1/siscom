<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Entidade;

use App\Models\Pena;

use App\Models\Frequencia;

use App\Models\TipoServico;

use App\Models\HistoricoServico;



use Carbon\Carbon;

class Servico extends Model
{
    use SoftDeletes;

     /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const CREATED_AT = 'dt_cadastro_servico';

     /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const UPDATED_AT = 'dt_atualizacao_servico';
    
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
     */
    const DELETED_AT = 'dt_exclusao_servico';

    /**
     * <b>SERV_SEMANAL</b> Constante representa o tipo de limite em relação a Servico que pode ser semanal. 
     * Exemplo: Um apenado pode prestar no minino 12 horas de serviço comunitario semanais e no maximo 14 horas.
     */
    const SERV_SEMANAL = 'Semanal';

    /**
     * <b>SERV_MENSAL</b> onstante representa o tipo de limite em relação a Servico que pode ser mensal.
     * Exemplo: Um apenado pode prestar no minino 30 horas de serviço comunitario mensais e no maximo 44 horas mensais.
     */
    const SERV_MENSAL  = 'Mensal';


    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */

    protected $primaryKey = "pk_servico";


    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
     */
    protected $dates = ['dt_cadastro_servico', 'dt_atualizacao_servico', 'dt_exclusao_servico'];

     /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
     */
     
    public $table = "sigmp_servico";

     /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */

    protected $fillable = [
                            'nr_hrs_servico', 
                            'nr_min_hrs_servico', 
                            'nr_max_hrs_servico', 
                            'ds_ativo_servico',
                            'nr_mes_minimo_servico',
                            'ds_observacao_servico',
                            'fk_pk_tipo_servico',
                            'fk_pk_pena', 
                            'fk_pk_entidade',
                        ];

                        

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'fk_pk_tipo_servico'            => 'bail|required|min:1', 
        'fk_pk_pena'                    => 'bail|required', 
        'fk_pk_entidade'                => 'bail|required', 
        'ds_ativo_servico'              => 'bail|required|numeric|min:0|max:1', 
        'nr_hrs_servico'                => 'bail|required|min:1', 
        'nr_min_hrs_servico'            => 'bail|required|min:1', 
        'nr_max_hrs_servico'            => 'bail|required|min:1', 
        'nr_mes_minimo_servico'         => 'bail|required', 
        'nr_min_sensibilizados_servico' => 'bail|nullable|min:0', 
        'ds_observacao_servico'         => 'bail|nullable|min:5',
        'dt_cadastro_servico'           => 'bail|date',
        'dt_atualizacao_servico'        => 'bail|date',
        'dt_exclusao_servico'           => 'bail|date',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'fk_pk_pena'                              => 'Pena: O campo Pena é obrigatório !', 
        'fk_pk_entidade'                          => 'Entidade: O campo Entidade é obrigatório !', 
        'fk_pk_tipo_servico.required'             => 'Tipo de Horas: O campo tipoHoras é obrigatório!',
        'nr_hrs_servico.required'                 => 'Horas: O campo Horas é obrigatório !',
        'nr_hrs_servico.min'                      => 'Horas: O campo Horas possui o valor minimo de 1!',
        'nr_min_hrs_servico.required'             => 'Horas minimas: O campo Horas minimas é obrigatório !',
        'nr_min_hrs_servico.min'                  => 'Horas Minimas: O campo Horas deve possui o valor minimo de 1!',
        'nr_max_hrs_servico.required'             => 'Horas Maximas: O campo Horas Maximas é obrigatório !',
        'nr_max_hrs_servico.min'                  => 'Horas Maximas: O campo Horas deve possui o valor minimo de 1!',
        'ds_ativo_servico.required'               => 'O campo Ativo é obrigatório !',
        'ds_ativo_servico.numeric'                => 'O campo Ativo é permitido apenas valores numericos !',
        'nr_min_sensibilizados_servico.min'       => 'Horas Maximas: O campo Horas deve possui o valor minimo de 0!',
        'nr_mes_minimo_servico.required'          => 'Prazo minimo: O campo prazoMinCumprimento é obrigatório !',
        'ds_observacao_servico.min'               => 'O campo observacoes deve ter valór mínimo de 5!'
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
    public $collection = "\App\Http\Resources\ServicoResource::collection";

    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\ServicoResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'id'                    => 'pk_servico',
        'pena'                  => 'fk_pk_pena', 
        'entidade'              => 'fk_pk_entidade',
        'tipoHoras'             => 'fk_pk_tipo_servico',
        'horasTotais'           => 'nr_hrs_servico', 
        'minutosPrestados'      => 'nr_min_prestados_servico',
        'minutosSensibilizados' => 'nr_min_sensibilizados_servico',
        'prazoMinCumprimento'   => 'nr_mes_minimo_servico',
        'horasMin'              => 'nr_min_hrs_servico', 
        'horasMax'              => 'nr_max_hrs_servico',
        'observacoes'           => 'ds_observacao_servico',
        'ativo'                 => 'ds_ativo_servico',
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
     * <b>entidade</b> Método responsável em definir o relacionamento entre as Models de Servico e Entidade e suas
     * respectivas tabelas.
     */
    public function entidade()
    {
        return $this->belongsTo(Entidade::class, 'fk_pk_entidade', 'pk_entidade');
    }

    /**
     * <b>pena</b> Método responsável em definir o relacionamento entre as Models de Servico e Pena e suas
     * respectivas tabelas.
     */
    public function pena()
    {
        return $this->belongsTo(Pena::class, 'fk_pk_pena', 'pk_pena');
    }

    /**
     * <b>frequencias</b> Método responsável em definir o relacionamento entre as Models de Servico e Frequencias e suas
     * respectivas tabelas.
     */
    public function frequencias()
    {
        return $this->hasMany(Frequencia::class, 'fk_pk_servico', 'pk_servico');
    }

    /**
     * <b>historicoServicos</b>  Método responsável em definir o relacionamento entre as Models de Servico e historicoServicos e suas
     * respectivas tabelas.
     */
    public function historicoServicos()
    {
        return $this->hasMany(HistoricoServico::class, 'fk_pk_servico', 'pk_servico');
    }

    /**
     * <b>tipoServico</b> Método responsável em definir o relacionamento entre as Models de Servico e tipoServico e suas
     * respectivas tabelas.
     */

    public function tipoServico()
    {
        return $this->belongsTo(TipoServico::class, 'fk_pk_tipo_servico', 'pk_tipo_servico');
    }

    /**
     * <b>motivos</b> Método responsável em definir o relacionamento entre as models de Apenado, Custas, Entidade, Multa, Pecunia, Servico e
     *  Vara e  e suas respectivas tabelas.Este relacionamento é do tipo poliformico(polymorphic) sendo 1:N(1 para muitos) no caso da model
     *  de motivo(esta atrelado a ação realizada:ativar, inativar e excluir) a mesma poderá ser utilizada por Custas, Entidade, Multa, Pecunia, Servico , então para diferenciar o motivo 
     *  é criado uma coluna ds_tipo_motivo e ds_id_motivo na tabela de motivo. 
     *  Veja mais sobre em : https://laravel.com/docs/5.5/eloquent-relationships#polymorphic-relations
    */
    public function motivos()
    {
     
        return $this->morphMany(Motivo::class, 'dsTipoMotivo', 'ds_tipo_motivo', 'ds_id_motivo');
    }


    ///////////////////////////////////////////////////////////////////
    ///////////////////// REGRAS DE NEGOCIO ///////////////////////////
    ///////////////////////////////////////////////////////////////////

     /**
     * <b>regraExclusao</b> Regras responsável em verificar se umaServico e seu historico podem ser excluidos logicamente.
     * REGRA: Para uma Servico ser excluida logicamente, a mesma deverá possuir apenas 1 registro em seu histórico e não deverá
     * possuir nenhum pagamento. 
     * 
     * @param  int  $id
     * @return $servico ou $error
     */

    public function regraExclusao($id)
    {
        //busca a servico informada
        $servico = $this->find($id); 
        //caso a servico exista
        if($servico != null)
        {
            $historico  = $servico->historicoServicos()->count();
            $frequencia = $servico->frequencias()->count();
            
          
            if($historico <= 1 && $frequencia == 0) 
            {
                return true;
            }
    
            $error['message'] = "O servico não pode ser excluída, devido a possuir frequencia";
            $error['error']   = true;
            
            return $error;
            
        }
        
        $error['message'] = "O serviço informada não existe";
        $error['error']   = true;
        
        return $error;

    }

    /**
     * <b>regraMinutos</b> Transforma os valores recebidos em horas para minutos
     * REGRA: As horasTotais, horasPrestadas, horasMin e horasMaxMes são convertidas para minutos antes de serem salvas no banco
     * @param Array $values
     * @return $values
     */
    public function regraMinutos(Array $values)
    {

        $keys = array_keys($values);

        foreach($keys as $key)
        {
         
            if(is_null($values[$key]))
            {
                unset($values[$key]);
                unset($keys[$key]);
            }

            if(isset($values[$key]) > 0)
            {
                $values[$key] = $values[$key] * 60;
            }
        
        }

        return $values;


    }

     /**
     *<b>regraAtivoEntidade</b> Método responsável em verificar se a entidade informado se encontra ativo
     * @param $idPena   (id da pena)
     * @param $idEntidade   (id da entidade)
     * @return true (caso o pena e a entidade exista) ou $error 
     */
    public function regraAtivo($idPena, $idEntidade)
    {
        
        $queryPena = Pena::find($idPena);
        $queryEntidade = Entidade::find($idEntidade);

        if(! is_null($queryPena) && ! is_null($queryEntidade))
        {
            $countPena = $queryPena->whereRaw("PK_PENA={$idPena} AND DS_ATIVO_PENA= 1")->count();

            if($countPena == 0)
            {
                $error['message'] = "A Pena informado(a) não esta ativa. Ação não permitida !";
                $error['error']   = true;
            
                return $error;
            }

            $countEntidade = $queryEntidade->whereRaw("PK_ENTIDADE={$idEntidade} AND DS_ATIVO_ENTIDADE= 1")->count();

            
            if($countEntidade == 0)
            {
                $error['message'] = "A Entidade informado(a) não esta ativa. Ação não permitida !";
                $error['error']   = true;
            
                return $error;

            }

           
        }else
        {
            $error['message'] = "A Pena ou Entidade informada não existe !";
            $error['error']   = true;
            
            return $error;
        }

       



    }

    /**
     * <b>regraHistorico</b> Método responsável realizar a gravação de seu respectivo historico.
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
            //Obtendo os dados do servico informado
            $servico = Servico::find($idServico);

            //Caso for usado para obter os dados anteriores
            if($tipoDeUso == 1)
            {
                $data = 
                [
                    //Criando o array com os dados anteriores presentes em Servico
                    'nr_hrs_servico'                  => $servico->nr_hrs_servico,
                    'nr_min_prestados_servico'        => $servico->nr_min_prestados_servico,
                    'nr_min_sensibilizados_servico'   => $servico->nr_min_sensibilizados_servico,
                    'nr_min_hrs_servico'              => $servico->nr_min_hrs_servico,
                    'nr_max_hrs_servico'              => $servico->nr_max_hrs_servico,
                    'nr_mes_minimo_servico'           => $servico->nr_mes_minimo_servico,
                    'fk_pk_entidade'                  => $servico->fk_pk_entidade,
                    'fk_pk_tipo_servico'              => $servico->fk_pk_tipo_servico,
                ];
            }
            //Caso for usado para atualizar o historico
            else
            {
                $nrHorasServicoAnteriores        = $dadosAnteriores->nr_hrs_servico ;
                $minutosPrestadosAnteriores      = $dadosAnteriores->nr_min_prestados_servico ;
                $minutosSensibilizadosAnteriores = $dadosAnteriores->nr_min_sensibilizados_servico ;
                $nrMinHorasAnteriores            = $dadosAnteriores->nr_min_hrs_servico ;
                $nrMaxHorasAnteriores            = $dadosAnteriores->nr_max_hrs_servico ;
                $nrMesMinAnterior                = $dadosAnteriores->nr_mes_minimo_servico ;
                $entidadeAnterior                = $dadosAnteriores->fk_pk_entidade ;
                $tipoServicoAnterior             = $dadosAnteriores->fk_pk_tipo_servico ;

                //Obtendo os dados após a atualização
                $nrHorasServicoAtualizados  = $servico->nr_hrs_servico ;
                $nrMinHorasAtualizados      = $servico->nr_min_hrs_servico ;
                $nrMaxHorasAtualizados      = $servico->nr_max_hrs_servico ;
                $nrMesMinAtualizado         = $servico->nr_mes_minimo_servico ;
                $entidadeAtualizado         = $servico->fk_pk_entidade ;
                $tipoServicoAtualizado      = $servico->fk_pk_tipo_servico ;

                $data = [
                    'nr_hrs_anterior'                => $nrHorasServicoAnteriores,
                    'nr_hrs_novo'                    => $nrHorasServicoAtualizados,
                    'nr_min_prestados_anterior'      => $minutosPrestadosAnteriores,
                    'nr_min_sensibilizados_anterior' => $minutosSensibilizadosAnteriores,
                    'nr_min_hrs_anterior'            => $nrMinHorasAnteriores,
                    'nr_min_hrs_novo'                => $nrMinHorasAtualizados,
                    'nr_max_hrs_anterior'            => $nrMaxHorasAnteriores,
                    'nr_max_hrs_novo'                => $nrMaxHorasAtualizados,
                    'nr_mes_minimo_anterior'         => $nrMesMinAnterior,
                    'nr_mes_minimo_novo'             => $nrMesMinAtualizado,
                    'fk_pk_entidade_anterior'        => $entidadeAnterior,
                    'fk_pk_entidade_novo'            => $entidadeAtualizado,
                    'fk_pk_tipo_servico_anterior'    => $tipoServicoAnterior,
                    'fk_pk_tipo_servico_novo'        => $tipoServicoAtualizado,
                    'ds_id_origem'                   => $idFrequencia,
                    'ds_tipo_origem'                 => 'App\Models\Servico',
                ];
                //grava o historico
                $historicoServico = $this->find($idFrequencia);
                $historicoServico->historicoServicos()->create($data);
            }

            return $data;
        }

        $error['message'] = "A Custas, Multa ou Pecunia informada não existe";
        $error['error']   = true;

        return $error;

    }



}
