<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Motivo;
use App\Models\Pena;

class Apenado extends Model
{

    
    use SoftDeletes;


    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
     */
    public $table = "sigmp_apenado";


    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [
                'nm_apenado', 
                'fk_pk_tipo_documento',
                'nm_mae_apenado',
                'nm_pai_apenado',
                'ds_tipo_documento_apenado',
                'ds_documento_apenado',
    ];

    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */

    const CREATED_AT = 'dt_cadastro_apenado';
    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */

    const UPDATED_AT = 'dt_atualizacao_apenado';
    
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
     */
    const DELETED_AT = 'dt_exclusao_apenado';

    /**
     * <b>tipoDocumento</b> Atributo estatico que contem o espelhamento dos tipos de documentos cadastrados 
     * OBS: Esse espelhamento deve ser igual aos valores contidos na tabela de parametro de tipo de documento.
     * TODO: Pegar dinamicamente (o ideal é pegar diretamente do BD para evitar dados desincronizados)
     */
    protected static $tipoDocumento = [
        '1' => 'CPF',
        '2' => 'RG',
        '3' => 'CNH',
        '4' => 'Título Eleitoral',
        '5' => 'Registro Profissional',
        '6' => 'Carteira Funcional',
        '7' => 'Passaporte',
        '8' => 'Estrangeiro'
    ];

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "pk_apenado";

    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
     */

    protected $dates = ['dt_cadastro_apenado', 'dt_atualizacao_apenado', 'dt_exclusao_apenado'];

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'nm_apenado'               => 'bail|required|min:5|max:150',
        'fk_pk_tipo_documento'     => 'bail|required|numeric|min:1|max:8',
        'nm_mae_apenado'           => 'bail|nullable|min:5|max:150',
        'nm_pai_apenado'           => 'bail|nullable|min:5|max:150',
        'ds_tipo_documento_apenado'=> 'bail|nullable|min:3',
        'ds_documento_apenado'     => 'bail|required|min:3',
        'dt_cadastro_apenado'      => 'bail|date',
        'dt_atualizacao_apenado'   => 'bail|date',
        'dt_exclusao_apenado'      => 'bail|date',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'ds_documento_apenado.required' => 'O campo documento é obrigatorio',
        'ds_documento_apenado.min'      => 'O campo nome deve conter o minino de 5 caracteres',
        'nm_apenado.required'           => 'O campo nome é obrigatório ',
        'nm_apenado.min'                => 'O campo nome tem o minino de 5 caracteres',
        'nm_apenado.max'                => 'O campo nome tem o maximo de 150 caracteres',
        'fk_pk_tipo_documento.required' => 'O campo tipoDocumento é obrigatório',
        'fk_pk_tipo_documento.numeric'  => 'O campo tipoDocumento deve ser numérico',
        'ds_tipo_documento_apenado.min' => 'O campo descricaoDocumento tem o minino de 3 caracteres',
        'nm_mae_apenado.min'            => 'O campo Nome da mãe tem o minino de 5 caracteres',
        'nm_mae_apenado.max'            => 'O campo Nome da mãe tem o maximo de 150 caracteres',
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
    public $collection = "\App\Http\Resources\ApenadoResource::collection";

    /**
     * <b>resource</b>
     */
    public $resource = "\App\Http\Resources\ApenadoResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
     */
    public $map = [
        'id'                 => 'pk_apenado',
        'nome'               => 'nm_apenado',
        'documento'          => 'ds_documento_apenado',
        'tipoDocumento'      => 'fk_pk_tipo_documento',
        'descricaoDocumento' => 'ds_tipo_documento_apenado',
        'nomeMae'            => 'nm_mae_apenado',
        'nomePai'            => 'nm_pai_apenado',
        'data_cadatro'       => 'dt_cadastro_apenado',
        'data_atualizacao'   => 'dt_atualizacao_apenado',
        'data_exclusao'      => 'dt_exclusao_apenado',
        
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
