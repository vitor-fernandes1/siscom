<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\TipoMulta;

use App\Models\HistoricoMulta;

use App\Models\Pagamento; 

use App\Models\Banco;


class Situacao extends Model
{
    use SoftDeletes;

    
    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const CREATED_AT = 'dt_cadastro_situacao';

     /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const UPDATED_AT = 'dt_atualizacao_situacao';
    
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
     */
    const DELETED_AT = 'dt_exclusao_situacao';

     /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "pk_situacao";

     /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
     */

    protected $dates = ['dt_cadastro_situacao', 'dt_atualizacao_situacao', 'dt_exclusao_situacao'];

     /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable  = [
                'ds_situacao',
        ];

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
     */
    public $table = "siscom_situacao";


    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'ds_situacao'             => 'bail|required|max:50',
        'dt_cadastro_situacao'    => 'bail|date',
        'dt_atualizacao_situacao' => 'bail|date',
        'dt_exclusao_situacao'    => 'bail|date',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'ds_situacao.required'      => 'O campo situacao  é obrigatório !',
        //'ds_situacao.min'           => 'O campo tipo da avalicao deve estar entre 1 e 3 !',
        //'ds_situacao.max'           => 'O campo tipo da avalicao deve estar entre 1 e 3 !',
        //'ds_situacao.numeric'       => 'O campo tipo da avalicao deve ser numerico !',
        'ds_situacao.max'           => 'O campo situacao deve conter no maximo 50 caracteres !',
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
    public $collection = "\App\Http\Resources\SituacaoResource::collection";

    /**
     * <b>resource</b>
    */
    public $resource = "\App\Http\Resources\SituacaoResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
    */
    public $map = [
        'id'               => 'pk_situacao',
        'situacao'         => 'ds_situacao',
        'data_cadastro'    => 'dt_cadastro_multa',
        'data_atualizacao' => 'dt_atualizacao_multa',
        'data_exclusao'    => 'dt_exclusao_multa',
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
     * <b>setVlMultaAttribute</b> Mutator que faz o tratamento antes do valor ser gravado no banco de dados
     * grava o valor substituindo a ,(virgula) por "nada" (vazio)
     * OBS: Mutator: Funções do model que modifica a informação antes ser gravada para o banco de dados
     */
    public function setVlMultaAttribute($value)
    {
     
        $this->attributes['vl_multa'] = str_replace(',', '', $value);
       
    }

    /**
     * <b>getVlMultaAttribute</b> Apresenta o valor com a ,(virgula) na casa do milhar e com .(ponto) na casa das dezenas
     * Exemplo: 5,600.48
     * OBS: Accesor: Funções do model que modifica a informação que vem do banco de dados antes de ser apresentada para o usuário
     */
    public function getVlMultaAttribute($value)
    {
      
        if(isset($value))
        {
            return money_format('%i', $value);
            //return number_format($value, 2, ".", ",");
        }
        return false;
    }  

   /**
     * <b>setVlPagoMultaAttribute</b> Mutator que faz o tratamento antes do valor ser gravado no banco de dados
     * grava o valor substituindo a ,(virgula) por "nada" (vazio)
     * OBS: Mutator: Funções do model que modifica a informação antes ser gravada para o banco de dados
     */
    public function setVlMultaPagoAttribute($value)
    {
     
        $this->attributes['vl_multa_pago'] = str_replace(',', '', $value);
       
    }

   /**
     * <b>getVlPagoMultaAttribute</b> Apresenta o valor com a ,(virgula) na casa do milhar e com .(ponto) na casa das dezenas
     * Exemplo: 5,600.48
     * OBS: Accesor: Funções do model que modifica a informação que vem do banco de dados antes de ser apresentada para o usuário
     */
    public function getVlMultaPagoAttribute($value)
    {
      
        if(isset($value))
        {
            return money_format('%i', $value);
        }
        return false;
    }  
    /**
     * <b>pena</b> Método responsável em definir o relacionamento entre as Models de Multa e Pena e suas
     * respectivas tabelas.
    */

    public function pena()
    {
        return $this->hasOne(Pena::class,'pk_pena', 'fk_pk_pena');
    
    }

    /**
     * <b>banco</b> Método responsável em definir o relacionamento entre as Models de Banco e Entidade e suas
     * respectivas tabelas.
     */
    public function banco()
    {
        return $this->hasOne(Banco::class,'pk_banco', 'fk_pk_banco');
    }

    /**
     * <b>pagamentos</b> Método responsável em definir o relacionamento entre as modeles de Custas, Multa e Pagamento e suas respectivas tabelas. 
     * Este relacionamento é do tipo poliformico(polymorphic) sendo 1:N(1 para muitos) no caso da model de pagamento
     * a mesma poderá ser utilizada por Multa e Pecunia, então para diferenciar o pagamento é criado uma coluna pagamentoable_tipo, 
     * na tabela de pagamento. 
     * Veja mais sobre em : https://laravel.com/docs/5.5/eloquent-relationships#polymorphic-relations
     * @return type 
    */
    public function pagamentos()
    {
        //return $this->morphMany(Pagamento::class, 'pagamentoable');

        return $this->morphMany(Pagamento::class, 'dsTipoPagamento', 'ds_tipo_pagamento', 'ds_id_pagamento');
    }

    /**
     * <b>tipoMulta</b> Método responsável em definir o relacionamento entre as Models de TipoMulta e Multa e suas
     * respectivas tabelas.
     */
    public function tipoMulta()
    {
        return $this->belongsTo(TipoMulta::class, 'fk_pk_tipo_multa', 'pk_tipo_multa');
    }


    /**
     * <b>historicoMultas</b> Método responsável em definir o relacionamento entre as Models de HistoricoMulta e Multa e suas
     * respectivas tabelas.
     */
    public function historicoMultas()
    {
        //return $this->hasManyThrough(HistoricoMulta::class, TipoMulta::class, 'fk_pk_tipo_multa', 'fk_pk_multa', 'pk_tipo_multa', 'pk_multa');
        return $this->hasMany(HistoricoMulta::class, 'fk_pk_multa', 'pk_multa');
    
    }


    /**
    * <b>motivos</b> Método responsável em definir o relacionamento entre as models de Apenado, Custas, Entidade, Multa, Pecunia, Servico e
    *  Vara e  e suas respectivas tabelas.Este relacionamento é do tipo poliformico(polymorphic) sendo 1:N(1 para muitos) no caso da model
    *  de motivo(esta atrelado a ação realizada:ativar, inativar e excluir) a mesma poderá ser utilizada por Custas, Entidade, Multa, Pecunia, Servico , então para diferenciar o motivo 
    *  é criado uma coluna ds_tipo_motivo e ds_id_motivo na tabela de motivo. 
    * Veja mais sobre em : https://laravel.com/docs/5.5/eloquent-relationships#polymorphic-relations
    */
    public function motivos()
    {
     
        return $this->morphMany(Motivo::class, 'dsTipoMotivo', 'ds_tipo_motivo', 'ds_id_motivo');
    }

    ///////////////////////////////////////////////////////////////////
   ///////////////////// REGRAS DE NEGOCIO ///////////////////////////
   ///////////////////////////////////////////////////////////////////


    /**
     * <b>regraExclusao</b> Regras responsável em verificar se uma multa e seu historico podem ser excluidos logicamente.
     * REGRA: Para uma multa ser excluida logicamente, a mesma deverá possuir apenas 1 registro em seu histórico e não deverá
     * possuir nenhum pagamento. 
     * @param  int  $id
     * @return $multa ou $error
     */
    public function regraExclusao($id)
    {
        //busca a multa informada
        $multa = $this->find($id); 
        //caso a multa exista
        if($multa != null)
        {
            $delete     = $multa; 
            $historico  = $multa->historicoMultas()->count();
            $pagamentos = $multa->pagamentos()->count();

            if($historico <= 1 && $pagamentos == 0) 
            {
                return $multa;
            }
    
            $error['message'] = "A multa não pode ser excluída, devido a possuir pagamentos";
            $error['error']   = true;
            
            return $error;
            
        }
        
        $error['message'] = "A multa informada não existe";
        $error['error']   = true;
        
        return $error;
       
     
    }


     /**
     * <b>regraAtivo</b> Método responsável em verificar se o pena informado se encontra ativo
     * @param $id   (id pena)
     * @return true (caso o pena exista) ou $error 
     */
    public function regraAtivo($id)
    {

        $query = Pena::find($id);
   
        if(! is_null($query))
        {
            $count = $query->whereRaw("PK_PENA={$id} AND DS_ATIVO_PENA= 1")->count();

            if($count > 0)
            {
                return true;
            }

            $error['message'] = "A Pena informado não esta ativa. Ação não permitida !";
            $error['error']   = true;
            
            return $error;

        }

        $error['message'] = "A Pena informado não existe !";
        $error['error']   = true;
        
        return $error;

   
    }

    /**
     * <b>regraHistorico</b> Método responsável realizar a gravação de seu respectivo historico.
     * @param $idPecunia
     * @param $dadosAnteriores
     * @param $tipoDeUso (1 = obter dados anteriores / outro nr qualquer = atualizar o historico)
     * @return $data ou error
    */
    public function regraHistorico($idMulta, $dadosAnteriores, $tipoDeUso)
    {
        if(!is_null($idMulta))
        {
            //Obtendo os dados do servico informado
            $multa = Multa::find($idMulta);

            //Caso for usado para obter os dados anteriores
            if($tipoDeUso == 1)
            {
                $data = 
                [
                    //Criando o array com os dados anteriores presentes em Servico
                    'vl_multa'                    => $multa->vl_multa,
                    'nr_parcelas_multa'           => $multa->nr_parcelas_multa,
                    'vl_multa_pago'               => $multa->vl_multa_pago,
                    'fk_pk_banco'                 => $multa->fk_pk_banco,
                    'ds_agencia_multa'            => $multa->ds_agencia_multa,
                    'ds_conta_multa'              => $multa->ds_conta_multa,
                    'fk_pk_tipo_multa'            => $multa->fk_pk_tipo_multa,
                    'dt_calculo_multa'            => $multa->dt_calculo_multa,
                ];
            }
            //Caso for usado para atualizar o historico
            else
            {
                $valorMultaAnterior          = $dadosAnteriores->vl_multa ;
                $nrParcelasAnterior          = $dadosAnteriores->nr_parcelas_multa ;
                $valorPagoAnterior           = $dadosAnteriores->vl_multa_pago ;
                $bancoAnterior               = $dadosAnteriores->fk_pk_banco ;
                $agenciaAnterior             = $dadosAnteriores->ds_agencia_multa ;
                $contaAnterior               = $dadosAnteriores->ds_conta_multa ;
                $tipoAnterior                = $dadosAnteriores->fk_pk_tipo_multa ;
                $dataCalculoAnterior         = $dadosAnteriores->dt_calculo_multa ;

                //Obtendo os dados após a atualização
                $valorMultaAtualizado          = $multa->vl_multa ;
                $nrParcelasAtualizado          = $multa->nr_parcelas_multa ;
                $valorPagoAtualizado           = $multa->vl_multa_pago ;
                $bancoAtualizado               = $multa->fk_pk_banco ;
                $agenciaAtualizado             = $multa->ds_agencia_multa ;
                $contaAtualizado               = $multa->ds_conta_multa ;
                $tipoAtualizado                = $multa->fk_pk_tipo_multa ;
                $dataCalculoAtualizado         = $multa->dt_calculo_multa ;

                $data = [
                    'vl_anterior'                => $valorMultaAnterior,
                    'vl_novo'                    => $valorMultaAtualizado,
                    'nr_parcelas_anterior'       => $nrParcelasAnterior,
                    'nr_parcelas_novo'           => $nrParcelasAtualizado,
                    'vl_pago_anterior'           => $valorPagoAnterior,
                    'vl_pago_novo'               => $valorPagoAtualizado,
                    'fk_pk_banco_anterior'       => $bancoAnterior,
                    'fk_pk_banco_novo'           => $bancoAtualizado,
                    'ds_agencia_anterior'        => $agenciaAnterior,
                    'ds_agencia_novo'            => $agenciaAtualizado,
                    'ds_conta_anterior'          => $contaAnterior,
                    'ds_conta_novo'              => $contaAtualizado,
                    'fk_pk_tipo_multa_anterior'  => $tipoAnterior,
                    'fk_pk_tipo_multa_novo'      => $tipoAtualizado,
                    'dt_calculo_anterior'        => $dataCalculoAnterior,
                    'dt_calculo_novo'            => $dataCalculoAtualizado,
                    'ds_id_origem'               => $idMulta,
                    'ds_tipo_origem'             => 'App\Models\Multa',
                ];
                //grava o historico
                $historicoMulta = $this->find($idMulta);
                $historicoMulta->historicoMultas()->create($data);
            }

            return $data;
        }

        $error['message'] = "A Custas, Multa ou Pecunia informada não existe";
        $error['error']   = true;

        return $error;

    }

    
}

