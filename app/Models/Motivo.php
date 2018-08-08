<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Motivo extends Model
{
    
    use SoftDeletes;


    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const CREATED_AT = 'dt_cadastro_motivo';
    
    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const UPDATED_AT = 'dt_atualizacao_motivo';
    
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
    */
    const DELETED_AT = 'dt_exclusao_motivo';


    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
    */
    protected $primaryKey = "pk_motivo";

    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
    */
    protected $dates = ['dt_cadastro_motivo', 'dt_atualizacao_motivo', 'dt_exclusao_motivo'];

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
    */
    protected $fillable=[ 
                          'ds_motivo',
                          'ds_acao_motivo',
                          'ds_tipo_motivo',
                          'ds_id_motivo',
                        ];

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    public $table = "sigmp_motivo";


    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'ds_motivo'             => 'bail|required|min:5|max:255',
        'ds_id_motivo'          => 'bail|required|numeric',
        'ds_tipo_motivo'        => 'bail|required|max:255',
        'dt_cadastro_motivo'    => 'bail|date',
        'dt_atualizacao_motivo' => 'bail|date',
        'dt_exclusao_motivo'    => 'bail|date',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'ds_motivo.required'      => 'O campo descricao do Motivo é obrigatório !',
        'ds_motivo.min'           => 'O campo descricao deve conter mínimo de 5 caracteres !',
        'ds_motivo.max'           => 'O campo descricao deve conter o máximo de 255 caracteres !',
        'ds_tipo_motivo.required' => 'O campo origem é obrigatório !',
        'ds_tipo_motivo.max'      => 'O campo origem deve conter o máximo de 255 caracteres !',
        'ds_id_motivo.required'   => 'O campo origemId é obrigatório !',
        'ds_id_motivo.numeric'    => 'O campo origemId deve conter apenas valores numericos!'
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
    public $collection = "\App\Http\Resources\MotivoResource::collection";

    /**
     * <b>resource</b>
    */
    public $resource = "\App\Http\Resources\MotivoResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
    */
    public $map = [
        'id'        => 'pk_motivo',
        'descricao' => 'ds_motivo',
        'acao'      => 'ds_acao_motivo',
        'origem'    => 'ds_tipo_motivo',
        'origemId'  => 'ds_id_motivo',
        'data'      => 'dt_cadastro_motivo',    
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
