<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class OpcaoParametro extends Model
{
    use SoftDeletes;

    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const CREATED_AT = 'dt_cadastro_opcao_parametro';

    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const UPDATED_AT = 'dt_atualiza_opcao_parametro';

    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
    */
    const DELETED_AT = 'dt_exclusao_opcao_parametro';


    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
    */
    protected $primaryKey = "pk_opcao_parametro";

    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
    */
    protected $dates = ['dt_cadastro_opcao_parametro', 'dt_atualiza_opcao_parametro', 'dt_exclusao_opcao_parametro'];

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *
    */
    protected $fillable=[ 'fk_pk_opcao',
                          'fk_pk_parametro',
                          'ds_id_opcao_parametro',
                          'ds_tipo_opcao_parametro',
                          'ds_ativo_opcao_parametro',
                        ];

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    public $table = "sigmp_opcao_parametro";


    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'fk_pk_opcao'                   => 'bail|required|numeric|min:1',
        'fk_pk_parametro'               => 'bail|required|numeric|min:1',
        'ds_id_opcao_parametro'         => 'bail|required|numeric',
        'ds_tipo_opcao_parametro'       => 'bail|required|',
        'dt_cadastro_opcao_parametro'   => 'bail|date',
        'dt_atualiza_opcao_parametro'   => 'bail|date',
        'dt_exclusao_opcao_parametro'   => 'bail|date',
        'ds_ativo_opcao_parametro'      =>  'bail|required|numeric|min:0|max:1',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'fk_pk_opcao.required'             => 'Nome: O campo Valor é obrigatório ',
        'fk_pk_parametro.required'         => 'Nome: O campo Valor tem o minino de 5 caracteres',
        'ds_id_opcao_parametro.required'   => 'Nome: O campo Valor tem o maximo de 50 caracteres',
        'ds_tipo_opcao_parametro.required' => 'Nome: O campo Valor tem o maximo de 50 caracteres',
        'ds_ativo_opcao_parametro.required'=> 'O campo ativo é obrigatório!',
        'ds_ativo_opcao_parametro.numeric' => 'O campo ativo deve conter apenas valores numericos!',
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
    public $collection = "\App\Http\Resources\OpcaoParametroResource::collection";

    /**
     * <b>resource</b>
    */
    public $resource = "\App\Http\Resources\OpcaoParametroResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
    */
    public $map = [
        'id'               => 'pk_opcao_parametro',
        'idOpcao'          => 'fk_pk_opcao',
        'idParametro'      => 'fk_pk_parametro',
        'idOrigem'         => 'ds_id_opcao_parametro',
        'Origem'           => 'ds_tipo_opcao_parametro',
        'data_cadatro'     => 'dt_cadastro_opcao_parametro',
        'data_atualizacao' => 'dt_atualizacao_opcao_parametro',
        'data_exclusao'    => 'dt_exclusao_opcao_parametro',
        'ativo'            => 'ds_ativo_opcao_parametro',
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
     * <b>opcoes</b> Método responsável em definir o relacionamento entre as Models de OpcaoParametro e Parametro e suas
     * respectivas tabelas.
    */
    public function opcoes()
    {
        return $this->belongsTo(Opcao::class, 'fk_pk_opcao', 'pk_opcao');
    }

    /**
     * <b>parametros</b> Método responsável em definir o relacionamento entre as Models de Opcao e Parametro e suas
     * respectivas tabelas.
    */
    public function parametros()
    {
        return $this->belongsTo(Parametro::class, 'fk_pk_parametro', 'pk_parametro');
    }

    /**
     * <b>dsTipoOpcaoParametro</b> Método responsável em definir o nome do relacionamento polimorfico (polymorphic) e o nome da coluna tipo.
     * No caso especifico deste relacionamento, quem irá utilizar o mesmo será a model de Entidade, E qualquer outra que necessitar de opções
     */
    public function dsTipoOpcaoParametro()
    {
        return $this->morphTo();
    }
}
