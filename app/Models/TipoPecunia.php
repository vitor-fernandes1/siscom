<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Pecunia;

class TipoPecunia extends Model
{
    use SoftDeletes;


    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */

    const CREATED_AT = "dt_cadastro_tipo_pecunia";

    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */

    const UPDATED_AT = "dt_atualizacao_tipo_pecunia";
    
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
    */
    
    const DELETED_AT = "dt_exclusao_tipo_pecunia";

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */

    public $table = "sigmp_tipo_pecunia";

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
    */

    protected $primaryKey="pk_tipo_pecunia"; 

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */

    protected $fillable = ['nm_tipo_pecunia'];

    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
     */
    protected $dates = ['dt_cadastro_tipo_pecunia', 'dt_atualizacao_tipo_pecunia', 'dt_exclusao_tipo_pecunia'];

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'nm_tipo_pecunia'             => 'bail|required|',
        'dt_cadastro_tipo_pecunia'    => 'bail|date',
        'dt_atualizacao_tipo_pecunia' => 'bail|date',
        'dt_exclusao_tipo_pecunia'    => 'bail|date',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */

    public $messages = [
        'nm_tipo_pecunia.required' => 'Nome: O campo Nome é obrigatório !',
    ];

    /**
     * <b>hidden</b> Atributo responsável em esconder colunas que não deverão ser retornadas em uma requisição
    */

    protected $hidden = [
        'rn', 
    ];

    /**
     *<b>collection</b> Atributo responsável em informar o namespace e o arquivo do resorce
     * O mesmo é utilizado em forma de facade.
     * OBS: Responsável em retornar uma coleção com os alias(apelido) atribuitos para cada coluna. 
     * Mais informações em https://laravel.com/docs/5.5/eloquent-resources
    */

    public $collection = "\App\Http\Resources\TipoPecuniaResource::collection";

    /**
     * <b>resource</b>
    */

    public $resource = "\App\Http\Resources\TipoPecuniaResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
    */

    public $map = [
        'id'               => 'pk_tipo_pecunia',
        'nome'             => 'nm_tipo_pecunia',
        'data_cadatro'     => 'dt_cadastro_tipo_pecunia',
        'data_atualizacao' => 'dt_atualizacao_tipo_pecunia',
        'data_exclusao'    => 'dt_exclusao_tipo_pecunia' 
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
     * <b>Pecunias</b> Método responsável em definir o relacionamento entre as Models de TipoPecunia e Pecunia e suas
     * respectivas tabelas.
    */

    public function pecunias ()
    {
        return $this->hasMany(Pecunia::class, 'fk_pk_tipo_pecunia', 'pk_tipo_pecunia');
    }

    



}
