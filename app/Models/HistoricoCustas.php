<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class HistoricoCustas extends Model
{

    use SoftDeletes;

    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const CREATED_AT = 'dt_cadastro_historico_custas';

    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const UPDATED_AT = 'dt_atualiza_historico_custas';


    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
    */
    const DELETED_AT = 'dt_exclusao_historico_custas';

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
    */
    protected $primaryKey = "pk_historico_custas";

    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
    */
    protected $dates = ['dt_cadastro_historico_custas', 'dt_atualiza_historico_custas', 'dt_exclusao_historico_custas'];

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *
    */
    protected $fillable=[
        'fk_pk_custas',
        'vl_anterior',
        'nr_parcelas_anterior',
        'vl_pago_anterior',
        'dt_calculo_anterior',
        'ds_id_origem',
        'ds_tipo_origem',
        'vl_novo',
        'nr_parcelas_novo',
        'vl_pago_novo',
        'dt_calculo_novo',

        'dt_cadastro_historico_custas',
        'dt_atualiza_historico_custas',
        'dt_exclusao_historico_custas',

    ];


    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    public $table = "sigmp_historico_custas";

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'fk_pk_custas'                => 'bail|numeric',
        'vl_anterior'                 => 'bail|numeric',
        'nr_parcelas_anterior'        => 'bail|numeric|min:1',
        'vl_pago_anterior'            => 'bail|numeric',
        'dt_calculo_anterior'         => 'bail|date|date_format:Y-m-d',

        'vl_novo'                     => 'bail|numeric',
        'nr_parcelas_novo'            => 'bail|numeric|min:1',
        'vl_pago_novo'                => 'bail|numeric',
        'dt_calculo_novo'             => 'bail|date|date_format:Y-m-d',
        'dt_cadastro_historico_custas'=> 'bail|date',
        'dt_atualiza_historico_custas'=> 'bail|date',
        'dt_exclusao_historico_custas'=> 'bail|date',


    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'fk_pk_custas.numeric'           => 'O campo Custas deve ser númerico',
        'vl_anterior.numeric'            => 'O campo Valor anterior deve ser númerico',
        'nr_parcelas_anterior.numeric'   => 'O campo Parcelas anterior deve ser númerico',
        'nr_parcelas_anterior.min'       => 'O campo Parcelas anterior deve ser igual ou maior que 1 !',
        'vl_pago_anterior.numeric'       => 'O campo Valor pago anterior deve ser númerico',
        'dt_calculo_anterior.date'       => 'O campo Data do calculo anterior deve informada no formato de data',
        'dt_calculo_anterior.date_format'=> 'O campo Data do calculo anterior deve deve ser no seguinte formato Y-m-d',

        'vl_novo.numeric'                 => 'O campo Valor novo deve ser númerico',
        'nr_parcelas_novo.numeric'        => 'O campo Parcelas novo deve ser númerico',
        'nr_parcelas_novo.min'            => 'O campo Parcelas novo deve ser igual ou maior que 1 !',
        'vl_pago_novo.numeric'            => 'O campo Valor pago novo deve ser númerico',
        'dt_calculo_novo.date'            => 'O campo Data do calculo novo deve informada no formato de data',
        'dt_calculo_anterior.date_format' => 'O campo Data do calculo novo deve ser no seguinte formato Y-m-d',
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
    public $collection = "\App\Http\Resources\HistoricoCustasResource::collection";

    /**
     * <b>resource</b>
    */
    public $resource = "\App\Http\Resources\HistoricoCustasResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
    */
    public $map = [
        'id'                   => 'pk_historico_custas',
        'custaId'              => 'fk_pk_custas',
        'idOrigem'             => 'ds_id_origem',
        'origem'               => 'ds_tipo_origem',
        'valorTotalAnterior'   => 'vl_anterior',
        'qtdeParcelasAnterior' =>  'nr_parcelas_anterior',
        'valorPagoAnterior'    =>  'vl_pago_anterior',
        'dataCalculoAnterior'  =>  'dt_calculo_anterior',

        'valorTotalNovo'      =>  'vl_novo',
        'qtdeParcelasNovo'    =>  'nr_parcelas_novo',
        'valorPagoNovo'       =>  'vl_pago_novo',
        'dataCalculoNovo'     =>  'dt_calculo_novo',

        'dataCadastro'        =>  'dt_cadastro_historico_custas',
        'dataAtualizacao'     =>  'dt_atualiza_historico_custas',
        'dataExclusao'        =>  'dt_exclusao_historico_custas',

    ];

    /**
     * <b>getPrimaryKey</b> Método responsável em retornar o nome da primaryKey.
     * OBS: Não é recomendado que este atributo seja publico, por isso foi realizado o encapsulamento
    */

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }



    ///////////////////////////////////////////////////////////////////
    ///////////////////// REGRAS DE NEGOCIO ///////////////////////////
    ///////////////////////////////////////////////////////////////////

}
