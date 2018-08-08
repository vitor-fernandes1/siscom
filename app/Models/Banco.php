<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Banco extends Model
{
    use SoftDeletes;


    /**
     * <b>CREATED_AT</b> Renomeia o campo padr�o created_at criado por padr�o quando utilizamos o metodo timestamps() na migration
     */

    const CREATED_AT = "dt_cadastro_banco";

    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padr�o updated_at criado por padr�o quando utilizamos o metodo timestamps() na migration
    */

    const UPDATED_AT = "dt_atualizacao_banco";
    
    /**
     * <b>DELETED_AT</b> Renomeia o campo padr�o deleted_at criado por padr�o quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclus�o logica de registros nativa do Laravel
    */
    
    const DELETED_AT = "dt_exclusao_banco";

    /**
     * <b>table</b> Informa qual � a tabela que o modelo ir� utilizar
    */

    public $table = "sigmp_bancos";

    /**
     * <b>primaryKey</b> Informa qual a � a chave primaria da tabela
    */

    protected $primaryKey="pk_banco"; 

    /**
     * <b>fillable</b> Informa quais colunas � permitido a inser��o de dados (MassAssignment)
     *  
     */

    protected $fillable = ['nm_banco', 'nr_banco'];
	
    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem tamb�m um objeto do tipo Carbon(biblioteca de datas)
     */
    protected $dates = ['dt_cadastro_banco', 'dt_atualizacao_banco', 'dt_exclusao_banco'];

    /**
     * <b>rules</b> Atributo respons�vel em definir regras de valida��o dos dados submetidos pelo formul�rio
     * OBS: A valida��o bail � respons�vel em parar a valida��o caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'nr_banco'          => 'bail|required|',
		'nm_banco'          => 'bail|required|',
    ];

    /**
     * <b>messages</b>  Atributo respons�vel em definir mensagem de valida��o de acordo com as regras especificadas no atributo $rules
    */

    public $messages = [
        'nm_banco.required'          => 'Nome: O Nome do banco é obrigatório !',
		'nr_banco.required'          => 'Número: O Número do banco é obrigatório !',
    ];

    /**
     * <b>hidden</b> Atributo respons�vel em esconder colunas que n�o dever�o ser retornadas em uma requisi��o
    */

    protected $hidden = [
        'rn', 
    ];

    /**
     *<b>collection</b> Atributo respons�vel em informar o namespace e o arquivo do resorce
     * O mesmo � utilizado em forma de facade.
     * OBS: Respons�vel em retornar uma cole��o com os alias(apelido) atribuitos para cada coluna. 
     * Mais informa��es em https://laravel.com/docs/5.5/eloquent-resources
    */

    public $collection = "\App\Http\Resources\BancoResource::collection";

    /**
     * <b>resource</b>
    */

    public $resource = "\App\Http\Resources\BancoResource";

    /**
     * <b>map</b> Atributo respons�vel em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo � utilizado no Metodo store e update da ApiControllerTrait
    */

    public $map = [
        'id'               => 'pk_banco',
        'nome'             => 'nm_banco',
		'numero'           => 'nr_banco',
        'data_cadastro'    => 'dt_cadastro_banco',
        'data_atualizacao' => 'dt_atualizacao_banco',
        'data_exclusao'    => 'dt_exclusao_banco' 
    ];

    /**
     * <b>getPrimaryKey</b> M�todo respons�vel em retornar o nome da primaryKey.
     * OBS: N�o � recomendado que este atributo seja publico, por isso foi realizado o encapsulamento
    */

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * <b>Retorna Banco</b>
     */
    public function banco()
    {
        return $this->hasMany(Banco::class, 'fk_pk_banco', 'pk_banco');
    }




    
    
}
