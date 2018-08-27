<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Equipamento extends Model
{
    use SoftDeletes;


    /**
     * <b>CREATED_AT</b> Renomeia o campo padr�o created_at criado por padr�o quando utilizamos o metodo timestamps() na migration
     */

    const CREATED_AT = "dt_cadastro_equipamento";

    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padr�o updated_at criado por padr�o quando utilizamos o metodo timestamps() na migration
    */

    const UPDATED_AT = "dt_atualizacao_equipamento";
    
    /**
     * <b>DELETED_AT</b> Renomeia o campo padr�o deleted_at criado por padr�o quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclus�o logica de registros nativa do Laravel
    */
    
    const DELETED_AT = "dt_exclusao_equipamento";

    /**
     * <b>table</b> Informa qual � a tabela que o modelo ir� utilizar
    */

    public $table = "siscom_equipamento";

    /**
     * <b>primaryKey</b> Informa qual a � a chave primaria da tabela
    */

    protected $primaryKey="pk_equipamento"; 

    /**
     * <b>fillable</b> Informa quais colunas � permitido a inser��o de dados (MassAssignment)
     *  
     */

    protected $fillable = [ 
                'nm_equipamento', 
                'dt_compra_equipamento',
                'ds_descricao_equipamento', 
                'ds_valor_equipamento',
                'fk_pk_tipo_equipamento',
            ];
	
    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem tamb�m um objeto do tipo Carbon(biblioteca de datas)
     */
    protected $dates = ['dt_cadastro_equipamento', 'dt_atualizacao_equipamento', 'dt_exclusao_equipamento'];

    /**
     * <b>rules</b> Atributo respons�vel em definir regras de valida��o dos dados submetidos pelo formul�rio
     * OBS: A valida��o bail � respons�vel em parar a valida��o caso um das que tenha sido especificada falhe
    */

    public $rules = [
        //'nm_nome_equipamento'          => 'bail|required|',
        'dt_compra_equipamento'        => 'bail|required|',
        'ds_descricao_equipamento'     => 'bail|max:300',
        'ds_valor_equipamento'         => 'bail|numeric|required|min:0',
        'fk_pk_tipo_equipamento'       => 'bail|required|min:1',
    ];

    /**
     * <b>messages</b>  Atributo respons�vel em definir mensagem de valida��o de acordo com as regras especificadas no atributo $rules
    */

    public $messages = [
        'dt_compra_equipamento.required'          => 'O campo data de compra é obrigatorio!',
        'ds_descricao_equipamento.max'            => 'A descrição deve conter no máximo 300 caracteres!',
        'ds_valor_equipamento.numeric'            => 'O campo valor é obrigatorio!',
        //'ds_valor_equipamento.required'           => 'O campo valor é obrigatorio!',
        'fk_pk_tipo_equipamento.required'         => 'O campo tipo de equipamento é obrigatorio',
        'fk_pk_tipo_equipamento.min'              => 'O campo tipo de equipamento deve conter valores maiores que 0',
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

    public $collection = "\App\Http\Resources\EquipamentoResource::collection";

    /**
     * <b>resource</b>
    */

    public $resource = "\App\Http\Resources\EquipamentoResource";

    /**
     * <b>map</b> Atributo respons�vel em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo � utilizado no Metodo store e update da ApiControllerTrait
    */

    public $map = [
        'id'               => 'pk_equipamento',
        'nome'             => 'nm_equipamento',
        'dataCompra'       => 'dt_compra_equipamento',
        'descricao'        => 'ds_descricao_equipamento',
        'valor'            => 'ds_valor_equipamento',
        'tipo'             => 'fk_pk_tipo_equipamento',
        'data_cadastro'    => 'dt_cadastro_equipamento',
        'data_atualizacao' => 'dt_atualizacao_equipamento',
        'data_exclusao'    => 'dt_exclusao_equipamento' 
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
     * <b>tipoEquipamento</b> Método responsável em definir o relacionamento entre as Models de TipoEquipamento e Manutençao e suas
     * respectivas tabelas.
     */
    public function tipoEquipamento()
    {
        return $this->hasMany(TipoEquipamento::class, 'fk_pk_tipo_equipamento', 'pk_tipo_equipamento');
    }




    
    
}
