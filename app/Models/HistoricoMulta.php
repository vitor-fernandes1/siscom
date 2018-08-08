<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Multa;

use App\Models\TipoMulta;

class HistoricoMulta extends Model
{
  use SoftDeletes;


    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const CREATED_AT  = 'dt_cadastro_historico_multa';
    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const UPDATED_AT  = 'dt_atualiza_historico_multa';
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
     */
    const DELETED_AT = 'dt_exclusao_historico_multa';

     /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
     */

    protected $dates = ['dt_cadastro_historico_multa', 'dt_atualiza_historico_multa', 'dt_exclusao_historico_multa'];

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "pk_historico_multa";



    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
     */
    public $table = "sigmp_historico_multa";


    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *
     */
    protected $fillable = [

        'fk_pk_multa',
        'ds_usuario_alteracao',
        'ds_id_origem',
        'ds_tipo_origem',

        'vl_anterior',
        'nr_parcelas_anterior',
        'vl_pago_anterior',
        'dt_calculo_anterior',
        'fk_pk_banco_anterior',
        'ds_agencia_anterior',
        'ds_conta_anterior',
        'fk_pk_tipo_multa_anterior',

        'vl_novo',
        'nr_parcelas_novo',
        'vl_pago_novo',
        'dt_calculo_novo',
        'fk_pk_banco_novo',
        'ds_agencia_novo',
        'ds_conta_novo',
        'fk_pk_tipo_multa_novo',
    ];



    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [

        'nr_parcelas_anterior'       => 'bail|numeric|min:1',
        'nr_parcelas_novo'           => 'bail|numeric|min:1',
        'dt_cadastro_historico_multa'=> 'bail|date',
        'dt_atualiza_historico_multa'=> 'bail|date',
        'dt_exclusao_historico_multa'=> 'bail|date',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [

        'nr_parcelas_anterior.numeric' => 'Horas: O campo Horas é obrigatório !',
        'nr_parcelas_anterior.min'     => 'Horas minimas: O campo Horas minimas é obrigatório !',
        'nr_parcelas_novo.numeric'     => 'Horas: O campo Horas é obrigatório !',
        'nr_parcelas_novo.min'         => 'Horas minimas: O campo Horas minimas é obrigatório !',

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
    public $collection = "\App\Http\Resources\HistoricoMultaResource::collection";

    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\HistoricoMulta";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [

            'id'                   => 'pk_historico_multa',
            'multaId'              => 'fk_pk_multa',
            'usuarioAlteracao'     => 'ds_usuario_alteracao',
            'idOrigem'             => 'ds_id_origem',
            'origem'               => 'ds_tipo_origem',
            'qtdeParcelasAnterior' => 'nr_parcelas_anterior',
            'valorTotalAnterior'   => 'vl_anterior',
            'valorPagoAnterior'    => 'vl_pago_anterior',
            'dataCalculoAnterior'  => 'dt_calculo_anterior',
            'bancoAnterior'        => 'fk_pk_banco_anterior',
            'bancoAnterior'        => 'fk_pk_banco_anterior',
            'agenciaAnterior'      => 'ds_agencia_anterior',
            'contaAnterior'        => 'ds_conta_anterior',
            'tipoAnterior'         => 'fk_pk_tipo_multa_anterior',

            'qtdeParcelasNovo'     => 'nr_parcelas_novo',
            'valorTotalNovo'       => 'vl_novo',
            'valorPagoNovo'        => 'vl_pago_novo',
            'dataCalculoNovo'      => 'dt_calculo_novo',
            'bancoNovo'            => 'fk_pk_banco_novo',
            'agenciaNovo'          => 'ds_agencia_novo',
            'contaNovo'            => 'ds_conta_novo',
            'tipoNovo'            => 'fk_pk_tipo_multa_novo',
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
