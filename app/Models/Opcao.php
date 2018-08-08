<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Opcao extends Model
{
    
    use SoftDeletes;

      /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const CREATED_AT = 'dt_cadastro_opcao';
    
    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const UPDATED_AT = 'dt_atualizacao_opcao';
    
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
    */
    const DELETED_AT = 'dt_exclusao_opcao';


    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
    */
    protected $primaryKey = "pk_opcao";

    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
    */
    protected $dates = ['dt_cadastro_opcao', 'dt_atualizacao_opcao', 'dt_exclusao_opcao'];

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
    */
    protected $fillable=[ 
                          'ds_opcao',
                        ];

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    public $table = "sigmp_opcao";


    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'dt_cadastro_opcao'   => 'bail|date',
        'dt_atualizacao_opcao'=> 'bail|date',
        'dt_exclusao_opcao'   => 'bail|date',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
       
       
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
    public $collection = "\App\Http\Resources\OpcaoResource::collection";

    /**
     * <b>resource</b>
    */
    public $resource = "\App\Http\Resources\OpcaoResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
    */
    public $map = [
        'id'                => 'pk_opcao',
        'chave'             => 'ds_opcao',
        'data_cadatro'      => 'dt_cadastro_opcao',
        'data_atualizacao'  => 'dt_atualizacao_opcao',
        'data_exclusao'     => 'dt_exclusao_opcao',
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
     * <b>parametros</b> Método responsável em definir o relacionamento entre as Models de Opcao e Parametro e suas
     * respectivas tabelas.
     */
    public function parametros()
    {
        return $this->hasMany(Parametro::class,'fk_pk_opcao', 'pk_opcao');
    }


}
