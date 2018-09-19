<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Avaliacao;
use App\Models\Empresa;
use App\Models\Equipamento;
use App\Models\Prioridade;
use App\Models\Situacao;
use App\Models\TipoManutencao;


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
                'ds_descricao_manutencao',
                'dt_manutencao',
                'vl_valor_manutencao',
                'fk_pk_tipo_manutencao',
                'fk_pk_prioridade',
                'fk_pk_situacao',
                'fk_pk_avaliacao',
                'fk_pk_empresa',
                'fk_pk_equipamento',
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

    protected $dates = ['dt_cadastro_manutencao', 'dt_atualizacao_manutencao', 'dt_exclusao_manutencao'];

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'ds_descricao_manutencao' => 'bail|max:100',
        'dt_manutencao'           => 'bail|required|date',
        'vl_valor_manutencao'     => 'bail|required|numeric',
        'fk_pk_tipo_manutencao'   => 'bail|required|', 
        'fk_pk_prioridade'        => 'bail|required|numeric|min:1|max:3',
        'fk_pk_situacao'          => 'bail|required|numeric|min:1|max:3',
        'fk_pk_avaliacao'         => 'bail|min:1|max:3',
        'fk_pk_empresa'           => 'bail|required|numeric|min:1',
        'fk_pk_equipamento'       => 'bail|required|numeric|min:1',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'ds_descricao_manutencao.max'   => 'O campo descrição tem no maximo 100 carateres',
        'dt_manutencao.required'        => 'O campo data da manutenção é obrigatorio',
        'vl_valor_manutencao.required'  => 'O campo valor é obrigatório ',

        'fk_pk_tipo_manutencao.required'      => 'O campo tipo é obrigatorio',
        
        'fk_pk_prioridade.required'      => 'O campo prioridade é obrigatorio',
        'fk_pk_prioridade.min'           => 'O campo prioridade deve estar entre 1 e 3 !',
        'fk_pk_prioridade.max'           => 'O campo prioridade deve estar entre 1 e 3 !',
        'fk_pk_prioridade.numeric'       => 'O campo prioridade deve ser numerico !',

        'fk_pk_situacao.required'      => 'O campo situacao é obrigatorio',
        'fk_pk_situacao.min'           => 'O campo situacao deve estar entre 1 e 3 !',
        'fk_pk_situacao.max'           => 'O campo situacao deve estar entre 1 e 3 !',
        'fk_pk_situacao.numeric'       => 'O campo situacao deve ser numerico !',

        'fk_pk_avaliacao.min'           => 'O campo avalicao deve estar entre 1 e 3 !',
        'fk_pk_avaliacao.max'           => 'O campo avalicao deve estar entre 1 e 3 !',
        'fk_pk_avaliacao.numeric'       => 'O campo avalicao deve ser numerico !',

        'fk_pk_empresa.required'      => 'O campo empresa é obrigatorio',
        'fk_pk_empresa.min'           => 'O campo empresa deve ser maior que 0 !',
        //'fk_pk_empresa.max'           => 'O campo tipo da avalicao deve estar entre 1 e 3 !',
        'fk_pk_empresa.numeric'       => 'O campo empresa deve ser numerico !',

        'fk_pk_equipamento.required'      => 'O campo equipamento é obrigatorio',
        'fk_pk_equipamento.min'           => 'O campo equipamento ser maior que 0 !',
        //'fk_pk_equipamento.max'           => 'O campo tipo da avalicao deve estar entre 1 e 3 !',
        'fk_pk_equipamento.numeric'       => 'O campo equipamento deve ser numerico !',
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
        'descricao'          => 'ds_descricao_manutencao',
        'data'               => 'dt_manutencao',
        'valor'              => 'vl_valor_manutencao',
        'tipo'               => 'fk_pk_tipo_manutencao',
        'prioridade'         => 'fk_pk_prioridade',
        'situacao'           => 'fk_pk_situacao',
        'avaliacao'          => 'fk_pk_avaliacao',
        'empresa'            => 'fk_pk_empresa',
        'equipamento'        => 'fk_pk_equipamento',
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
     * <b>avaliacao</b> Método responsável em definir o relacionamento entre as Models de Avaliacao e Manutençao e suas
     * respectivas tabelas.
     */
    public function avaliacao()
    {
      
        return $this->hasMany(Avaliacao::class, 'fk_pk_avaliacao', 'pk_avaliacao');
    
    }

    /**
     * <b>empresa</b> Método responsável em definir o relacionamento entre as Models de Empresa e Manutençao e suas
     * respectivas tabelas.
     */
    public function empresa()
    {
      
        return $this->hasMany(Empresa::class, 'fk_pk_empresa', 'pk_empresa');
    
    }

    /**
     * <b>equipamento</b> Método responsável em definir o relacionamento entre as Models de Equipamento e Manutençao e suas
     * respectivas tabelas.
     */
    public function equipamento()
    {
      
        return $this->hasMany(Equipamento::class, 'fk_pk_equipamento', 'pk_equipamento');
    
    }

    /**
     * <b>prioridade</b> Método responsável em definir o relacionamento entre as Models de Prioridade e Manutençao e suas
     * respectivas tabelas.
     */
    public function prioridade()
    {
      
        return $this->hasMany(Prioridade::class, 'fk_pk_prioridade', 'pk_prioridade');
    
    }

    /**
     * <b>situacao</b> Método responsável em definir o relacionamento entre as Models de Situacao e Manutençao e suas
     * respectivas tabelas.
     */
    public function situacao()
    {
      
        return $this->hasMany(Situacao::class, 'fk_pk_situacao', 'pk_situacao');
    
    }

    /**
     * <b>tipoManutencao</b> Método responsável em definir o relacionamento entre as Models de TipoManutencao e Manutençao e suas
     * respectivas tabelas.
     */
    public function tipoManutencao()
    {
      
        return $this->hasMany(TipoManutencao::class, 'fk_pk_tipo_manutencao', 'pk_tipo_manutencao');
    
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
