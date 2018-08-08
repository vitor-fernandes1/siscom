<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Pena;

use App\Models\Entidade;

use App\Models\Pagamento;

use App\Models\HistoricoPecunia;

use App\Models\Banco;

class Pecunia extends Model
{
    use SoftDeletes;


    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */ 
    const CREATED_AT = 'dt_cadastro_pecunia';
    
    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
     */
    const UPDATED_AT = 'dt_atualizacao_pecunia';
    
    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
     */
    const DELETED_AT = 'dt_exclusao_pecunia';

     /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
     */
    protected $primaryKey = "pk_pecunia";

     /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
     */
    protected $dates = ['dt_cadastro_pecunia', 'dt_atualizacao_pecunia', 'dt_exclusao_pecunia', 'dt_pecunia'];

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
     */
    protected $fillable = [
                            'vl_pecunia', 
                            'nr_parcelas_pecunia', 
                            'vl_pago_pecunia', 
                            'nr_dia_vencimento_pecunia', 
                            'ds_ativo_pecunia',
                            'fk_pk_banco',
                            'ds_agencia_pecunia',
                            'ds_conta_pecunia',
                            'ds_observacao_pecunia',
                            'fk_pk_pena',
                            'fk_pk_entidade',
                            'fk_pk_tipo_pecunia',
                            ];

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
     */

    public $table = "sigmp_pecunia";


    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'vl_pecunia'                => 'bail|required',
        'nr_parcelas_pecunia'       => 'bail|required|numeric', 
        'vl_pago_pecunia'           => 'bail|nullable|min:0',
        'ds_ativo_pecunia'          => 'bail|required|numeric|min:0|max:1',
        'fk_pk_tipo_pecunia'        => 'bail|required|numeric|min:1',
        'fk_pk_pena'                => 'bail|required|numeric',
        'fk_pk_entidade'            => 'bail|nullable|numeric|not_in:fk_pk_banco', // TODO: verificar
        'nr_dia_vencimento_pecunia' => 'bail|required|numeric|min:1|max:31',
        'fk_pk_banco'               => 'bail|nullable|numeric|required_without:fk_pk_entidade',
        'ds_agencia_pecunia'        => 'bail|nullable|required_with:fk_pk_banco',
        'ds_conta_pecunia'          => 'bail|nullable|required_with:ds_agencia_pecunia',
        'ds_observacao_pecunia'     => 'bail|nullable',
        'dt_cadastro_pecunia'       => 'bail|date',
        'dt_atualizacao_pecunia'    => 'bail|date',
        'dt_exclusao_pecunia'       => 'bail|date',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'nr_parcelas_pecunia.required'       => 'O campo qtdeParcelas é obrigatório!',
        'nr_parcelas_pecunia.numeric'        => 'O campo qtdeParcelas deve conter apenas valores numericos!',
        'vl_pecunia.required'                => 'O campo valorTotal da Pecunia é obrigatório!',
        'ds_ativo_pecunia.required'          => 'O campo ativo é obrigatório!',
        'ds_ativo_pecunia.numeric'           => 'O campo ativo deve conter apenas valores numericos!',
        'nr_dia_vencimento_pecunia.required' => 'O campo diaVencimento é obrigatório !',
        'nr_dia_vencimento_pecunia'          => 'O campo diaVencimento deve ser numérico!',
        'nr_dia_vencimento_pecunia.min'      => 'O campo diaVencimento possui o valor minimo de 1!',
        'nr_dia_vencimento_pecunia.max'      => 'O campo diaVencimento possui o valor maximo de 31!',
        'fk_pk_tipo_pecunia.required'        => 'O campo tipo é obrigatório',
        'fk_pk_tipo_pecunia.numeric'         => 'O campo tipo deve conter apenas valores numericos!',
        'fk_pk_banco.required'               => 'O campo banco é obrigatório quando para tipo Pagamento em Juízo',
        'fk_pk_banco.required_without'       => 'O campo banco é obrigatório quando para tipo Pagamento em Juízo',
        'fk_pk_banco.numeric'                => 'O campo banco deve conter apenas valores numericos!',
        'fk_pk_entidade.not_in'              => 'O campo entidade é obrigatório para tipo Doação para Entidade',
        'fk_pk_entidade.numeric'             => 'O campo entidade deve conter apenas valores numericos!',
        'ds_agencia_pecunia.required_with'   => 'O campo agencia deve ser preenchido junto com o banco',
        'ds_conta_pecunia.required_with'     => 'O campo conta deve ser preenchido junto com o banco'
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
    public $collection = "\App\Http\Resources\PecuniaResource::collection";

    /**
     * <b>resource</b>
    */
    public $resource = "\App\Http\Resources\PecuniaResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
    */
    public $map = [
        'id'               => 'pk_pecunia',
        'pena'           => 'fk_pk_pena',
        'entidade'         => 'fk_pk_entidade',
        'tipo'             => 'fk_pk_tipo_pecunia',
        'diaVencimento'    => 'nr_dia_vencimento_pecunia',
        'valorTotal'       => 'vl_pecunia',
        'valorPago'        => 'vl_pago_pecunia',
        'qtdeParcelas'     => 'nr_parcelas_pecunia',
        'ativo'            => 'ds_ativo_pecunia',
        'banco'            => 'fk_pk_banco',
        'agencia'          => 'ds_agencia_pecunia',
        'conta'            => 'ds_conta_pecunia',
        'observacoes'      => 'ds_observacao_pecunia',
        'data_cadastro'     => 'dt_cadastro_pecunia',
        'data_atualizacao' => 'dt_atualizacao_pecunia',
        'data_exclusao'    => 'dt_exclusao_pecunia',
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
     * <b>setVlPecuniaAttribute</b> Mutator que faz o tratamento antes do valor ser gravado no banco de dados
     * grava o valor substituindo a ,(virgula) por "nada" (vazio)
     * OBS: Mutator: Funções do model que modifica a informação antes ser gravada para o banco de dados
     */
    public function setVlPecuniaAttribute($value)
    {
     
        $this->attributes['vl_pecunia'] = str_replace(',', '', $value);
       
    }

    /**
     * <b>getVlPecuniaAttribute</b> Apresenta o valor com a ,(virgula) na casa do milhar e com .(ponto) na casa das dezenas
     * Exemplo: 5,600.48
     * OBS: Accesor: Funções do model que modifica a informação que vem do banco de dados antes de ser apresentada para o usuário
     */
    public function getVlPecuniaAttribute($value)
    {
      
        if(isset($value))
        {
            return money_format('%i', $value);
        }
        return false;
    }  

   /**
     * <b>setVlPagoPecuniaAttribute</b> Mutator que faz o tratamento antes do valor ser gravado no banco de dados
     * grava o valor substituindo a ,(virgula) por "nada" (vazio)
     * OBS: Mutator: Funções do model que modifica a informação antes ser gravada para o banco de dados
     */
    public function setVlPagoPecuniaAttribute($value)
    {
     
        $this->attributes['vl_pago_pecunia'] = str_replace(',', '', $value);
       
    }

   /**
     * <b>getVlPagoPecuniaAttribute</b> Apresenta o valor com a ,(virgula) na casa do milhar e com .(ponto) na casa das dezenas
     * Exemplo: 5,600.48
     * OBS: Accesor: Funções do model que modifica a informação que vem do banco de dados antes de ser apresentada para o usuário
     */
    public function getVlPagoPecuniaAttribute($value)
    {
      
        if(isset($value))
        {
            return money_format('%i', $value);
        }
        return false;
    }  
    
    
    

    /**
     * <b>pena</b> Método responsável em definir o relacionamento entre as Models de Pecunia e Pena e suas
     * respectivas tabelas.
    */
    public function pena()
    {
        return $this->belongsTo(Pena::class, 'fk_pk_pena', 'pk_pena');
    }

    /**
     * <b>pagamentos</b> Método responsável em definir o relacionamento entre as Models de Pecunia e Pagamento e suas
     * respectivas tabelas.
    */

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
     * <b>tipoPecunia</b> Método responsável em definir o relacionamento entre as Models de TipoPecunia e Pecunia e suas
     * respectivas tabelas.
     */
    public function tipoPecunia()
    {
        return $this->belongsTo(TipoPecunia::class, 'fk_pk_tipo_pecunia', 'pk_tipo_pecunia');
    }

    /**
     * <b>historicoPecunias</b> Método responsável em definir o relacionamento entre as Models de HistoricoPecunia e Pecunia e suas
     * respectivas tabelas.
     */
    public function historicoPecunias()
    {
        return $this->hasMany(HistoricoPecunia::class, 'fk_pk_pecunia', 'pk_pecunia');

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
     * <b>banco</b> Método responsável em definir o relacionamento entre as Models de Pecunia e banco e suas
     * respectivas tabelas.
    */
    public function banco()
    {
        return $this->hasOne(Banco::class, 'pk_banco', 'fk_pk_banco');
    }

    /**
     * <b>banco</b> Método responsável em definir o relacionamento entre as Models de Pecunia e banco e suas
     * respectivas tabelas.
    */
    public function entidade()
    {
        return $this->hasOne(Entidade::class, 'pk_entidade', 'fk_pk_entidade');
    }


    
   ///////////////////////////////////////////////////////////////////
   ///////////////////// REGRAS DE NEGOCIO ///////////////////////////
   ///////////////////////////////////////////////////////////////////

     /**
     * <b>regraExclusao</b> Regras responsável em verificar se uma pecunia e seu historico podem ser excluidos logicamente.
     * REGRA: Para uma pecunia ser excluida logicamente, a mesma deverá possuir apenas 1 registro em seu histórico e não deverá
     * possuir nenhum pagamento. 
     * @param  int  $id
     * @return $pecunia ou $error
     */

    public function regraExclusao($id)
    {

        //busca a pecunia informada
        $pecunia = $this->find($id); 
        //caso a pecunia exista
        if($pecunia != null)
        {
            $delete     = $pecunia; 
            $historico  = $pecunia->historicoPecunias()->count();
            $pagamentos = $pecunia->pagamentos()->count();

            if($historico <= 1 && $pagamentos == 0) 
            {
                return $pecunia;
            }
    
            $error['message'] = "A pecunia não pode ser excluída, devido a possuir pagamentos";
            $error['error']   = true;
            
            return $error;
            
        }
        
        $error['message'] = "A pecunia informada não existe";
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
    public function regraHistorico($idPecunia, $dadosAnteriores, $tipoDeUso)
    {
        if(!is_null($idPecunia))
        {
            //Obtendo os dados do servico informado
            $pecunia = Pecunia::find($idPecunia);

            //Caso for usado para obter os dados anteriores
            if($tipoDeUso == 1)
            {
                $data = 
                [
                    //Criando o array com os dados anteriores presentes em Servico
                    'vl_pecunia'                    => $pecunia->vl_pecunia,
                    'nr_parcelas_pecunia'           => $pecunia->nr_parcelas_pecunia,
                    'vl_pago_pecunia'               => $pecunia->vl_pago_pecunia,
                    'nr_dia_vencimento_pecunia'     => $pecunia->nr_dia_vencimento_pecunia,
                    'fk_pk_banco'                   => $pecunia->fk_pk_banco,
                    'ds_agencia_pecunia'            => $pecunia->ds_agencia_pecunia,
                    'ds_conta_pecunia'              => $pecunia->ds_conta_pecunia,
                ];
            }
            //Caso for usado para atualizar o historico
            else
            {
                $valorPecuniaAnterior        = $dadosAnteriores->vl_pecunia ;
                $nrParcelasAnterior          = $dadosAnteriores->nr_parcelas_pecunia ;
                $valorPagoAnterior           = $dadosAnteriores->vl_pago_pecunia ;
                $nrDiaVencimentoAnterior     = $dadosAnteriores->nr_dia_vencimento_pecunia ;
                $bancoAnterior               = $dadosAnteriores->fk_pk_banco ;
                $agenciaAnterior             = $dadosAnteriores->ds_agencia_pecunia ;
                $contaAnterior               = $dadosAnteriores->ds_conta_pecunia ;

                //Obtendo os dados após a atualização
                $valorPecuniaAtualizado        = $pecunia->vl_pecunia ;
                $nrParcelasAtualizado          = $pecunia->nr_parcelas_pecunia ;
                $valorPagoAtualizado           = $pecunia->vl_pago_pecunia ;
                $nrDiaVencimentoAtualizado     = $pecunia->nr_dia_vencimento_pecunia ;
                $bancoAtualizado               = $pecunia->fk_pk_banco ;
                $agenciaAtualizado             = $pecunia->ds_agencia_pecunia ;
                $contaAtualizado               = $pecunia->ds_conta_pecunia ;

                $data = [
                    'vl_anterior'                => $valorPecuniaAnterior,
                    'vl_novo'                    => $valorPecuniaAtualizado,
                    'nr_parcelas_anterior'       => $nrParcelasAnterior,
                    'nr_parcelas_novo'           => $nrParcelasAtualizado,
                    'vl_pago_anterior'           => $valorPagoAnterior,
                    'vl_pago_novo'               => $valorPagoAtualizado,
                    'nr_dia_vencimento_anterior' => $nrDiaVencimentoAnterior,
                    'nr_dia_vencimento_novo'     => $nrDiaVencimentoAtualizado,
                    'fk_pk_banco_anterior'       => $bancoAnterior,
                    'fk_pk_banco_novo'           => $bancoAtualizado,
                    'ds_agencia_anterior'        => $agenciaAnterior,
                    'ds_agencia_novo'            => $agenciaAtualizado,
                    'ds_conta_anterior'          => $contaAnterior,
                    'ds_conta_novo'              => $contaAtualizado,
                    'ds_id_origem'               => $idPecunia,
                    'ds_tipo_origem'             => 'App\Models\Pecunia',
                ];
                //grava o historico
                $historicoPecunia = $this->find($idPecunia);
                $historicoPecunia->historicoPecunias()->create($data);
            }

            return $data;
        }

        $error['message'] = "A Custas, Multa ou Pecunia informada não existe";
        $error['error']   = true;

        return $error;

    }


}

   
