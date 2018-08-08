<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{
    
    use SoftDeletes;
    
    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const CREATED_AT = 'dt_cadastro_endereco';

     /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const UPDATED_AT = 'dt_atualizacao_endereco';
    
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
     */
    const DELETED_AT = 'dt_exclusao_endereco';

     /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "pk_endereco";

     /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
     */

    protected $dates = ['dt_cadastro_endereco', 'dt_atualizacao_endereco', 'dt_exclusao_endereco'];

     /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable  = ['ds_logradouro_endereco', 
                            'ds_bairro_endereco',
                            'ds_complemento_endereco',
                            'ds_localidade_endereco',
                            'ds_uf_endereco',
                            'ds_cep_endereco',
                            'ds_tipo_endereco',
                            'ds_id_endereco',
                            ];

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */

    public $table = "sigmp_endereco";
    
    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'ds_logradouro_endereco'  => 'bail|required|min:3|max:100',
        'ds_bairro_endereco'      => 'bail|required|min:3|max:30',
        'ds_complemento_endereco' => 'bail|nullable|min:3|max:30',
        'ds_localidade_endereco'  => 'bail|required|min:3|max:30',
        'ds_uf_endereco'          => 'bail|required|min:2|max:2',
        'ds_cep_endereco'         => 'bail|required|min:8|max:8',
        'ds_id_endereco'          => 'bail|required|numeric',
        'ds_tipo_endereco'        => 'bail|required',
        'dt_cadastro_endereco'    => 'bail|date',
        'dt_atualizacao_endereco' => 'bail|date',
        'dt_exclusao_endereco'    => 'bail|date',

    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'ds_logradouro_endereco.required' => 'Logradouro: O campo Logradouro é obrigatório !', 
        'ds_bairro_endereco.required'     => 'Bairro: O campo Bairro é obrigatório !',
        'ds_complemento_endereco.min'     => 'Complemento: Caso seja informado, deverá possuir pelo menos 3 caracteres!',
        'ds_localidade_endereco.required' => 'Localidade: O campo Localidade é obrigatório ',
        'ds_uf_endereco.required'         => 'UF: O campo UF é obrigatório ',
        'ds_cep_endereco.required'        => 'CEP: O campo CEP é obrigatório ',
        'ds_id_endereco.required'         => 'UF: O campo UF é obrigatório ',
        'ds_tipo_endereco.required'        => 'CEP: O campo CEP é obrigatório ',
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
    public $collection = "\App\Http\Resources\EnderecoResource::collection";

    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\EnderecoResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'id'               => 'pk_endereco',
        'logradouro'       => 'ds_logradouro_endereco',
        'bairro'           => 'ds_bairro_endereco',
        'complemento'      => 'ds_complemento_endereco',
        'localidade'       => 'ds_localidade_endereco',
        'uf'               => 'ds_uf_endereco',
        'cep'              => 'ds_cep_endereco',
        'origem'           => 'ds_tipo_endereco',
        'origemId'         => 'ds_id_endereco',
        'data_cadastro'    => 'dt_cadastro_endereco',
        'data_atualizacao' => 'dt_atualizacao_endereco',
        'data_exclusao'    => 'dt_exclusao_endereco'
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
     * <b>motivos</b> Método responsável em definir o relacionamento entre as models de Apenado, Custas, Entidade, Multa, Pecunia, Servico e
     *  Vara e  e suas respectivas tabelas.Este relacionamento é do tipo poliformico(polymorphic) sendo 1:N(1 para muitos) no caso da model
     *  de motivo(esta atrelado a ação realizada:ativar, inativar e excluir) a mesma poderá ser utilizada por Custas, Entidade, Multa, Pecunia, Servico , então para diferenciar o motivo 
     *  é criado uma coluna ds_tipo_motivo e ds_id_motivo na tabela de motivo. 
     *  Veja mais sobre em : https://laravel.com/docs/5.5/eloquent-relationships#polymorphic-relations
    */
    public function motivos()
    {
     
        return $this->morphMany(Motivo::class, 'dsTipoMotivo', 'ds_tipo_motivo', 'ds_id_motivo');
    }

    /**
     * <b>dsTipoEndereco</b> Método responsável em definir o relacionamento entre as models de Apenado e Entidade e suas respectivas tabelas. 
     * Este relacionamento é do tipo poliformico(polymorphic) sendo 1:N(1 para muitos) no caso da model de Endereço
     * a mesma poderá ser utilizada por Apenado e Entidade, então para diferenciar o Endereço é criado uma coluna ds_id_endereco e ds_tipo_endereco, 
     * na tabela de endereço. 
     * Veja mais sobre em : https://laravel.com/docs/5.5/eloquent-relationships#polymorphic-relations
     * @return type 
     *     
     */

    public function dsTipoEndereco()
    {
        return $this->morphTo();
    }

}
