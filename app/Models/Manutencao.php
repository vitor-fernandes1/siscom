<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class Manutencao extends Model
{

    
    use SoftDeletes;


    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
     */
    public $table = "siscom_manutencao";


    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [
                'descricao',
                'data_manutencao',
                'valor',
                'fk_pk_tipo_documento',
    ];

    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */

    const CREATED_AT = 'dt_cadastro_manutencao';
    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */

    const UPDATED_AT = 'dt_atualizacao_manutencao';
    
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
     */
    const DELETED_AT = 'dt_exclusao_manutencao';

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "pk_manutencao";

    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
     */

    protected $dates = ['dt_cadastro_apenado', 'dt_atualizacao_apenado', 'dt_exclusao_apenado'];

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'descricao'               => 'bail|max:100',
        'data_manutencao'         => 'bail|required|date',
        'valor'                   => 'bail|required|numeric|',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'descricao.max'                 => 'O campo descrição tem no maximo 100 carateres',
        'data_manutencao.required'      => 'O campo data da manutenção é obrigatorio',
        'valor.required'                => 'O campo valor é obrigatório ',
    ];

    /**
     * <b>hidden</b> Atributo responsável em esconder colunas que não deverão ser retornadas em uma requisição
    */
    protected $hidden  = [
        'rn', 
    ];
    /**
     *<b>collection</b> Atributo responsável em informar o namespace e o arquivo do resource
     * O mesmo é utilizado em forma de facade.
     * OBS: Responsável em retornar uma coleção com os alias(apelido) atribuidos para cada coluna. 
     * Mais informações em https://laravel.com/docs/5.5/eloquent-resources
    */
    public $collection = "\App\Http\Resources\ManutencaoResource::collection";

    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\ManutencaoResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'id'                 => 'pk_manutencao',
        'data'               => 'data_manutencao',
        'valor'              => 'valor_manutenção',
        'tipoDocumento'      => 'fk_pk_tipo_documento',
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
     * <b>getTipoDocumento</b>
     */
    public static function getTipoDocumento()
    {
        return self::$tipoDocumento;
    }

    /**
     * <b>pena</b> Método responsável em definir o relacionamento entre as Models de Apenado e Pena e suas
     * respectivas tabelas.
     */
    public function pena()
    {
        //return $this->belongsTo(Pena::class, 'pk_apenado', 'fk_pk_apenado');
        return $this->hasOne(Pena::class, 'fk_pk_apenado', 'pk_apenado');
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
    * <b>enderecos</b> Método responsável em definir o relacionamento entre as models de Apenado e Endereco
    *  Este relacionamento é do tipo poliformico(polymorphic) sendo 1:N(1 para muitos) no caso da model
    *  de Endereco a mesma poderá ser utilizada por Apenado e Entidade, então para diferenciar o endereco 
    *  é criado uma coluna ds_tipo_endereco e ds_id_endereco na tabela de endereco. 
    *  Veja mais sobre em : https://laravel.com/docs/5.5/eloquent-relationships#polymorphic-relations
    */
    public function enderecos()
    {
        return $this->morphMany(Endereco::class, 'dsTipoEndereco', 'ds_tipo_endereco', 'ds_id_endereco');
    }

     /**
     * <b>TipoDocumento</b> Método responsável em definir o relacionamento entre as Models de TipoDocumento e Apenado e suas
     * respectivas tabelas.
     */
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'fk_pk_tipo_documento', 'pk_tipo_documento');
    }

  
    ///////////////////////////////////////////////////////////////////
    ///////////////////// REGRAS DE NEGOCIO ///////////////////////////
    ///////////////////////////////////////////////////////////////////

    

    /**
     * <b>regraExclusao</b> Regras responsável em verificar se uma Apenado e seu historico podem ser excluidos logicamente.
     * REGRA: Para uma Apenado ser excluida logicamente, a mesma deverá possuir apenas 1 registro em seu histórico e não deverá
     * possuir nenhum pagamento. 
     * 
     * @param  int  $id
     * @return true ou $error
     */
    public function regraExclusao($id)
    {

         //busca a apenado informada
         $apenado = $this->find($id); 
         //caso a apenado exista
         if($apenado != null)
         {
             $penas  = $apenado->pena()->count();
         
             if($penas == 0) 
             {
                 return true;
             }
     
             $error['message'] = "O apenado não pode ser excluída, devido a possuir pena";
             $error['error']   = true;
             
             return $error;
             
         }
         
         $error['message'] = "A apenado informada não existe";
         $error['error']   = true;
         
         return $error;
    }
    /**
     * <b>regraDocumento</b> Regra responsável em verificar se o documento informado foi ou não cadastrado.
     * @param char $documento
     * @param int $id
     * @return true ou $error
     */
    public function regraDocumento($documento, $id = null)
    {
        //dd($documento);
         //caso o id esteja preenchido verifica se alguem exceto o usuario que esta atualizando o registro já tenha cadastrado o cpf informado
         $condition = (!empty($id) ? "PK_APENADO !={$id} AND" : '');
         $query = $this->whereRaw("{$condition} DS_DOCUMENTO_APENADO='{$documento}'");
         //dd($query->count());
         $count = $query->count();
         if($count >= 1)
         {
             $error['message'] = "Documento informado já esta cadastrado ! ";
             $error['error']   = true;
             
             return $error;
         }

        return true;
    }

 

    
}
