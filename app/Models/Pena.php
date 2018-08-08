<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Apenado;

use App\Models\Servico;

use App\Models\Pecunia;

use App\Models\Custas;

use App\Models\Vara;



class Pena extends Model
{
    use SoftDeletes;

   
    
    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const CREATED_AT  = 'dt_cadastro_pena';
    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const UPDATED_AT  = 'dt_atualizacao_pena';
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
     */
    const DELETED_AT = 'dt_exclusao_pena';

     /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
     */

    protected $dates = ['dt_cadastro_pena', 'dt_atualizacao_pena', 'dt_exclusao_pena'];

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "pk_pena";



    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
     */
    public $table = "sigmp_pena";
    

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [
                'fk_pk_apenado',
                'fk_pk_vara',
                'fk_pk_status_pena',
                'nr_processo_pena',
                'ds_pena', 
                'ds_ativo_pena',
                
    ];
 
    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'nr_processo_pena'   => 'bail|required',
        'ds_pena'            => 'bail|required',
        'fk_pk_apenado'      => 'bail|required|numeric|min:1',
        'fk_pk_vara'         => 'bail|required|numeric',
        'fk_pk_status_pena'  => 'bail|required|numeric|min:1',
        'ds_ativo_pena'      => 'bail|required|numeric|min:0|max:1',
        'dt_cadastro_pena'   => 'bail|date',
        'dt_atualizacao_pena'=> 'bail|date',
        'dt_exclusao_pena'   => 'bail|date',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'nr_processo_pena.required' => 'Processo: O campo Processo é obrigatório !',
        'ds_pena.required'          => 'Descrição: O campo Descrição é obrigatório !',
        'fk_pk_apenado.required'    => 'Apenado: O campo Descrição é obrigatório !',
        'fk_pk_apenado.numeric'     => 'Apenado: O campo Apenado  deve conter apenas valores numericos !',
        'fk_pk_vara.required'       => 'Vara: O campo Vara é obrigatório !',
        'fk_pk_vara.numeric'        => 'Vara: O campo Vara  deve conter apenas valores numericos !',
        'fk_pk_status_pena.required'=> 'Status: O campo Status é obrigatório !',
        'fk_pk_status_pena.numeric' => 'Status: O campo Status  deve conter apenas valores numericos !',
        'ds_ativo_pena.required'    => 'Ativo: O campo Ativo é obrigatório !',
        'ds_ativo_pena.numeric'     => 'Ativo: O campo Ativo  deve conter apenas valores numericos !',
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
    public $collection = "\App\Http\Resources\PenaResource::collection";

    /**
     * <b>resource</b>
    */
    public $resource = "\App\Http\Resources\PenaResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
    */
    public $map = [
        'id'               => 'pk_pena',
        'vara'             => 'fk_pk_vara',
        'apenado'          => 'fk_pk_apenado',
        'numProcesso'      => 'nr_processo_pena',
        'descricao'        => 'ds_pena',
        'ativo'            => 'ds_ativo_pena',
        'status'           => 'fk_pk_status_pena',
        'data_cadatro'     => 'dt_cadastro_pena',
        'data_atualizacao' => 'dt_atualizacao_pena',
        'data_exclusao'    => 'dt_exclusao_pena',
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
     * <b>apenado</b> Método responsável em definir o relacionamento entre as Models de Pena e Apenado e suas
     * respectivas tabelas.
     */
    public function apenado()
    {
        return $this->hasOne(Apenado::class,'pk_apenado', 'fk_pk_apenado');
        //return $this->belongsTo(Apenado::class,'pk_apenado', 'fk_pk_apenado');

    }

    /**
     * <b>servicos</b> Método responsável em definir o relacionamento entre as Models de Pena e Servico e suas
     * respectivas tabelas.
     */
    public function servicos()
    {
        return $this->hasMany(Servico::class, 'fk_pk_pena', 'pk_pena');
    }

    /**
     * <b>pecuniarias</b> Método responsável em definir o relacionamento entre as Models de Pena e Pecunia e suas
     * respectivas tabelas.
     */
    public function pecunias()
    {
        return $this->hasMany(Pecunia::class, 'fk_pk_pena', 'pk_pena');
    }


     /**
     * <b>multas</b> Método responsável em definir o relacionamento entre as Models de Pena e Multa e suas
     * respectivas tabelas.
     */

    public function multas()
    {
        return $this->hasMany(Multa::class, 'fk_pk_pena', 'pk_pena');
    }

    /**
     * <b>custas</b> Método responsável em definir o relacionamento entre as Models de Pena e Custas e suas
     * respectivas tabelas.
     */

     public function custas()
     {
         return $this->hasMany(Custas::class, 'fk_pk_pena', 'pk_pena');
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
     * <b>regraAtivo</b> Método responsável em verificar se o vara informado se encontra ativo
     * @param int $idVara   (id vara)
     * @return true (caso o vara exista) ou $error 
     */
    public function regraAtivo($idVara)
    {

        $query = Vara::find($idVara);
   
        if(! is_null($query))
        {
            $count = $query->whereRaw("PK_VARA={$idVara} AND DS_ATIVO_VARA= 1")->count();

            if($count > 0)
            {
                return true;
            }

            $error['message'] = "A Vara informado não esta ativa. Ação não permitida !";
            $error['error']   = true;
            
            return $error;

        }

        $error['message'] = "A Vara informada não existe !";
        $error['error']   = true;
        
        return $error;

   
    }

    /**
     * <b>regraExclusao</b> Regras responsável em verificar se uma Pena pode ser excluida logicamente.
     * REGRA: Para uma Servico ser excluida logicamente, a mesma deverá possuir Custa, Multa, Pecunia e Servico que não tiveram 
     * nenhuma alteração ou seja, nenhum pagamento ou frequencia relacionado ao mesmo. 
     * 
     * @param  int  $id (id da pena)
     * @return true ou $error
     */

    public function regraExclusao($id)
    {
        $pena = $this->find($id); 

        if($pena != null)
        {
            //obtem os servicos atrelados a pena, conta todos e contaliza a quantidade de frequencias
            $servicos = $pena->servicos()->get();
            $frequencias = 0;
            for($i = 0; $i < $servicos->count(); $i++)
            {
                $frequencias+= $servicos[$i]->frequencias()->count();
            }
            //obtem os pecunias atreladas a pena, conta todos e contaliza a quantidade de pagamentos de pecunia
            $pecunias = $pena->pecunias()->get();
            $pagamentosPecunia = 0;
            for($i = 0; $i < $pecunias->count(); $i++)
            {
                $pagamentosPecunia+= $pecunias[$i]->pagamentos()->count();
            }
            //obtem os multas atreladas a pena, conta todos e contaliza a quantidade de pagamentos de multa
            $multas = $pena->multas()->get();
            $pagamentosMulta = 0;
            for($i = 0; $i < $multas->count(); $i++)
            {
                $pagamentosMulta = $multas[$i]->pagamentos()->count();
            }
            //obtem os custas atreladas a pena, conta todos e contaliza a quantidade de pagamentos de custas
            $custas = $pena->custas()->get();
            $pagamentosCusta = 0;
            for($i = 0; $i < $custas->count(); $i++)
            {
                $pagamentosCusta = $custas[$i]->pagamentos()->count();
            }
          
            if($frequencias == 0 && $pagamentosCusta == 0 && $pagamentosMulta == 0 && $pagamentosPecunia == 0) 
            {
                return true;
            }

            $error['message'] = "A Pena não pode ser excluída, devido a possuir ligações";
            $error['error']   = true;
            
            return $error;
        }

        $error['message'] = "A Pena informada não existe";
        $error['error']   = true;
        
        return $error;
    }



}
