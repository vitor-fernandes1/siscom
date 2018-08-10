<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Avaliacao extends Model
{
    
    use SoftDeletes;


    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const CREATED_AT = 'dt_cadastro_avaliacao';
    
    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const UPDATED_AT = 'dt_atualizacao_avaliacao';
    
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
    */
    const DELETED_AT = 'dt_exclusao_avaliacao';


    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
    */
    protected $primaryKey = "pk_avaliacao";

    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
    */
    protected $dates = ['dt_cadastro_avaliacao', 'dt_atualizacao_avaliacao', 'dt_exclusao_avaliacao'];

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
    */
    protected $fillable=[ 
                          'ds_avaliacao',
                        ];

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    public $table = "siscom_avaliacao";


    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'ds_avaliacao'             => 'bail|required|max:50',
        'dt_cadastro_avaliacao'    => 'bail|date',
        'dt_atualizacao_avaliacao' => 'bail|date',
        'dt_exclusao_avaliacao'    => 'bail|date',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'ds_avaliacao.required'      => 'O campo avaliacao  é obrigatório !',
        //'ds_avaliacao.min'           => 'O campo tipo da avalicao deve estar entre 1 e 3 !',
        //'ds_avaliacao.max'           => 'O campo tipo da avalicao deve estar entre 1 e 3 !',
        //'ds_avaliacao.numeric'       => 'O campo tipo da avalicao deve ser numerico !',
        'ds_avaliacao.max'           => 'O campo avaliacao deve conter no maximo 50 caracteres !',

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
    public $collection = "\App\Http\Resources\AvaliacaoResource::collection";

    /**
     * <b>resource</b>
    */
    public $resource = "\App\Http\Resources\AvaliacaoResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
    */
    public $map = [
        'id'        => 'pk_avaliacao',
        'avaliacao' => 'ds_avaliacao',
    ];

    /**
     * <b>aliasMorph</b> Atributo responsável em associar o tipo de Motivo ao namespace correto da classe (Multa ou Pecunia)
     */
    public $aliasMorph = [
        'apenado'  => 'App\Models\Apenado',
        'custas'   => 'App\Models\Custas',
        'entidade' => 'App\Models\Entidade',
        'multa'    => 'App\Models\Multa',
        'pecunia'  => 'App\Models\Pecunia',
        'pena'     => 'App\Models\Pena',
        'servico'  => 'App\Models\Servico',
        'vara'     => 'App\Models\Vara',
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
     * <b>dsTipoMotivo</b>
     */

    public function dsTipoMotivo()
    {
        return $this->morphTo();
    }





}
