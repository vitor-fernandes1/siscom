<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Pena;

class Vara extends Model
{
    use SoftDeletes;

     
    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const CREATED_AT = 'dt_cadastro_vara';

     /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const UPDATED_AT = 'dt_atualizacao_vara';
    
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
     */
    const DELETED_AT = 'dt_exclusao_vara';

     /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "pk_vara";

     /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
     */

    protected $dates = ['dt_cadastro_vara', 'dt_atualizacao_vara', 'dt_exclusao_vara'];

     /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable  = ['nm_vara',
                            'cd_vara',
                            'cd_secsubsec_vara',
                            'nm_responsavel_vara',
                            'ds_email_vara',
                            'ds_telefone_vara',
                            'ds_ativo_vara',
                           ];

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
     */
    public $table = "sigmp_vara";


    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
     */

    public $rules = [
        'nm_vara'            => 'bail|required|min:3|max:50',
        'cd_vara'            => 'bail|required',
        'cd_secsubsec_vara'  => 'bail|required',
        'nm_responsavel_vara'=> 'bail|required',
        'ds_email_vara'      => 'bail|required',
        'ds_telefone_vara'   => 'bail|required',
        'ds_ativo_vara'      => 'bail|required|numeric|min:0|max:1',
        'dt_cadastro_vara'   => 'bail|date',
        'dt_atualizacao_vara'=> 'bail|date',
        'dt_exclusao_vara'   => 'bail|date',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */

    public $messages = [
        'nm_vara.required'            => 'Nome: O campo nome é obrigatório !',
        'cd_vara.required'            => 'Nome: O campo Codigo é obrigatório !',
        'cd_secsubsec_vara.required'  => 'Nome: O campo SecSubSec é obrigatório !',
        'nm_responsavel_vara.required'=> 'Nome: O campo Responsável é obrigatório !',
        'ds_email_vara.required'      => 'Nome: O campo Email é obrigatório !',
        'ds_telefone_vara.required'   => 'Nome: O campo Telefone é obrigatório !',
        'ds_ativo_vara.required'      => 'Nome: O campo Ativo é obrigatório !',
        'ds_ativo_vara.numeric'       => 'Nome: O campo Ativo só permite valores numericos !',
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
    public $collection = "\App\Http\Resources\VaraResource::collection";

    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\VaraResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'id'               => 'pk_vara',
        'nome'             => 'nm_vara',
        'codigoVara'       => 'cd_vara',
        'secsubsec'        => 'cd_secsubsec_vara',
        'contato'          => 'nm_responsavel_vara',
        'email'            => 'ds_email_vara',
        'telefone'         => 'ds_telefone_vara',
        'ativo'            => 'ds_ativo_vara',
        'data_cadatro'     => 'dt_cadastro_vara',
        'data_atualizacao' => 'dt_atualizacao_vara',
        'data_exclusao'    => 'dt_exclusao_vara'
       
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
     * <b>penas</b>
     */
    public function penas()
    {
        return $this->hasMany(Pena::class, 'fk_pk_vara', 'pk_vara');
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

    ///////////////////////////////////////////////////////////////////
    ///////////////////// REGRAS DE NEGOCIO ///////////////////////////
    ///////////////////////////////////////////////////////////////////

    
    /**
     * <b>regraExclusao</b> Regras responsável em verificar se uma Vara pode ser excluida logicamente.
     * REGRA: Para uma Vara ser excluida logicamente, a mesma deverá possuir nenhuma Pena atrelada a ela
     * 
     * @param  int  $id
     * @return $servico ou $error
     */

    public function regraExclusao($id)
    {
        //busca a servico informada
        $vara = $this->find($id); 
        //caso a vara exista
        if($vara != null)
        {
            $penas  = $vara->penas()->count();
           
            if($penas == 0) 
            {
                return true;
            }
    
            $error['message'] = "A vara não pode ser excluída, devido a possuir pena";
            $error['error']   = true;
            
            return $error;
            
        }
        
        $error['message'] = "A Vara informada não existe";
        $error['error']   = true;
        
        return $error;

    }
 

}
