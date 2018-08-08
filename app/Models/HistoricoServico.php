<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class HistoricoServico extends Model
{
    use SoftDeletes;


    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const CREATED_AT  = 'dt_cadastro_historico_servico';
    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const UPDATED_AT  = 'dt_atualiza_historico_servico';
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
     */
    const DELETED_AT = 'dt_exclusao_historico_servico';

     /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
     */

    protected $dates = ['dt_cadastro_historico_servico', 'dt_atualiza_historico_servico', 'dt_exclusao_historico_servico'];

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "pk_historico_servico";



    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
     */
    public $table = "sigmp_historico_servico";


    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *
     */
    protected $fillable = [
                            'fk_pk_servico',
                            'ds_usuario_alteracao',
                            'ds_id_origem',
                            'ds_tipo_origem',
                            'fk_pk_tipo_servico_anterior',
                            'fk_pk_entidade_anterior',
                            'nr_hrs_anterior',
                            'nr_min_prestados_anterior',
                            'nr_min_hrs_anterior',
                            'nr_max_hrs_anterior',
                            'nr_mes_minimo_anterior',
                            'nr_min_sensibilizados_anterior',

                            'fk_pk_tipo_servico_novo',
                            'fk_pk_entidade_novo',
                            'nr_hrs_novo',
                            'nr_min_prestados_novo',
                            'nr_min_hrs_novo',
                            'nr_max_hrs_novo',
                            'nr_mes_minimo_novo',
                            'nr_min_sensibilizados_novo',

                        ];


    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [

        'fk_pk_servico'                => 'bail|required|numeric',
        'dt_cadastro_historico_servico'=> 'bail|date',
        'dt_atualiza_historico_servico'=> 'bail|date',
        'dt_exclusao_historico_servico'=> 'bail|date',

    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [

        'fk_pk_servico.required'       => 'Serviço: O campo Serviço é obrigatório !',
        'fk_pk_servico.numeric'        => 'Serviço: O campo Serviço deve ser informado apenas números',


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
    public $collection = "\App\Http\Resources\HistoricoServicoResource::collection";

    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\HistoricoServico";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [

      'id'                            => 'pk_historico_servico',
      'servico'                       => 'fk_pk_servico',
      'usuarioAlteracao'              => 'ds_usuario_alteracao',
      'idOrigem'                      => 'ds_id_origem',
      'origem'                        => 'ds_tipo_origem',
      'tipoHorasAnterior'             => 'fk_pk_tipo_servico_anterior',
      'EntidadeAnterior'              => 'fk_pk_entidade_anterior',
      'horasMinMesAnterior'           => 'nr_min_hrs_anterior',
      'horasMaxMesAnterior'           => 'nr_max_hrs_anterior',
      'horasTotaisAnterior'           => 'nr_hrs_anterior',
      'prazoMinCumprimentoAnterior'   => 'nr_mes_minimo_anterior',
      'minutosPrestadosAnterior'      => 'nr_min_sensibilizados_anterior',
      'minutosSensibilizadosAnterior' => 'nr_min_prestados_anterior',

      'tipoHorasNovo'                 => 'fk_pk_tipo_servico_novo',
      'EntidadeNovo'                  => 'fk_pk_entidade_novo',
      'horasMinMesNovo'               => 'nr_min_hrs_novo',
      'horasMaxMesNovo'               => 'nr_max_hrs_novo',
      'horasTotaisNovo'               => 'nr_hrs_novo',
      'prazoMinCumprimentoNovo'       => 'nr_mes_minimo_novo',
      'minutosPrestadosNovo'          => 'nr_min_prestados_novo',
      'minutosSensibilizadosNovo'     => 'nr_min_sensibilizados_novo',
    ];

    /**
     * <b>getPrimaryKey</b> Método responsável em retornar o nome da primaryKey.
     * OBS: Não é recomendado que este atributo seja publico, por isso foi realizado o encapsulamento
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

}
