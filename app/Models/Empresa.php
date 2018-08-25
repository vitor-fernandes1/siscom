<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Empresa extends Model
{
   
    use SoftDeletes;
    
    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const CREATED_AT = 'dt_cadastro_empresa';
    
    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const UPDATED_AT = 'dt_atualizacao_empresa';
    

    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
    */
    const DELETED_AT = 'dt_exclusao_empresa';

    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
    */
    protected $primaryKey = "pk_empresa";

    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
    */
    protected $dates = ['dt_cadastro_empresa', 'dt_atualizacao_empresa', 'dt_exclusao_empresa', ];

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *  
    */
    protected $fillable=[
                    'nm_empresa',
                    'ds_endereco_empresa',
                    'ds_telefone_empresa',
                    'ds_email_empresa',
                    'ds_cnpj_empresa',
                ];

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    public $table = "siscom_empresa";

    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        //'nm_empresa'            => 'bail|required|numeric',
        'ds_endereco_empresa'   => 'bail|max:100',
        'ds_telefone_empresa'   => 'bail|max:16',
        'ds_email_empresa'      => 'bail|max:150',
        'ds_cnpj_empresa'       => 'bail|max:18',
        'dt_cadastro_empresa'    => 'bail|date',
        'dt_atualizacao_empresa' => 'bail|date',
        'dt_exclusao_empresa'    => 'bail|date',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'ds_endereco_empresa.max'         => 'O campo endereco deve conter no máximo 100 caracteres!',
        'ds_telefone_empresa.required'    => 'O campo telefone deve conter no máximo 16 caracteres!',
        'ds_email_empresa.max'            => 'O campo email deve conter no máximo 150 caracteres!',
        'ds_cnpj_empresa.max'             => 'O campo CNPJ deve conter no máximo 18 caracteres!',
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
    public $collection = "\App\Http\Resources\EmpresaResource::collection";

    /**
     * <b>resource</b>
    */
    public $resource = "\App\Http\Resources\EmpresaResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
    */
    public $map = [
        'id'               => 'pk_empresa',
        'nome'             => 'nm_empresa',
        'endereco'       => 'ds_endereco_empresa',
        'telefone'     => 'ds_telefone_empresa',
        'email'        => 'ds_email_empresa',
        'cnpj'            => 'ds_cnpj_empresa',
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
     * <b>setVlCustasAttribute</b> Mutator que faz o tratamento antes do valor ser gravado no banco de dados
     * grava o valor substituindo a ,(virgula) por "nada" (vazio)
     * OBS: Mutator: Funções do model que modifica a informação antes ser gravada para o banco de dados
     */
    public function setVlCustasAttribute($value)
    {
     
        $this->attributes['vl_custas'] = str_replace(',', '', $value);
       
    }

    /**
     * <b>getVlCustasAttribute</b> Apresenta o valor com a ,(virgula) na casa do milhar e com .(ponto) na casa das dezenas
     * Exemplo: 5,600.48
     * OBS: Accesor: Funções do model que modifica a informação que vem do banco de dados antes de ser apresentada para o usuário
     */
    public function getVlCustasAttribute($value)
    {
      
        if(isset($value))
        {
            return money_format('%i', $value);
            //return number_format($value, 2, ".", ",");
        }
        return false;
    }  

   /**
     * <b>setVlPagoCustasAttribute</b> Mutator que faz o tratamento antes do valor ser gravado no banco de dados
     * grava o valor substituindo a ,(virgula) por "nada" (vazio)
     * OBS: Mutator: Funções do model que modifica a informação antes ser gravada para o banco de dados
     */
    public function setVlPagoCustasAttribute($value)
    {
     
        $this->attributes['vl_pago_custas'] = str_replace(',', '', $value);
       
    }

   /**
     * <b>getVlPagoCustasAttribute</b> Apresenta o valor com a ,(virgula) na casa do milhar e com .(ponto) na casa das dezenas
     * Exemplo: 5,600.48
     * OBS: Accesor: Funções do model que modifica a informação que vem do banco de dados antes de ser apresentada para o usuário
     */
    public function getVlPagoCustasAttribute($value)
    {
      
        if(isset($value))
        {
            return money_format('%i', $value);
        }
        return false;
    }  
    
    /**
     * <b>pena</b> Método responsável em definir o relacionamento entre as Models de Custas e Pena e suas
     * respectivas tabelas.
     */
    public function pena()
    {
        return $this->hasOne(Pena::class,'pk_pena', 'fk_pk_pena');
    
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
        return $this->morphMany(Pagamento::class, 'dsTipoPagamento', 'ds_tipo_pagamento', 'ds_id_pagamento');
    }


    /**
     * <b>historicoCustas</b> Método responsável em definir o relacionamento entre as Models de HistoricoCustas e Custas e suas
     * respectivas tabelas.
     */
    public function historicoCustas()
    {
      
        return $this->hasMany(HistoricoCustas::class, 'fk_pk_custas', 'pk_custas');
    
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
     * <b>regraAtivo</b> Método responsável em verificar se o pena informado se encontra ativo
     * @param $id   (id custas)
     * @return true (caso o custas exista) ou $error 
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
     * <b>regraExclusao</b> Regras responsável em verificar se uma Custas e seu historico podem ser excluidos logicamente.
     * REGRA: Para uma Custas ser excluida logicamente, a mesma deverá possuir apenas 1 registro em seu histórico e não deverá
     * possuir nenhum pagamento. 
     * 
     * @param  int  $id
     * @return $custas ou $error
     */
    public function regraExclusao($id)
    {

         //busca a custas informada
         $custas = $this->find($id); 
         //caso a custas exista
         if($custas != null)
         {
             $historico  = $custas->historicoCustas()->count();
             $pagamentos = $custas->pagamentos()->count();
             
             if($historico <= 1 && $pagamentos == 0) 
             {
                 return true;
             }
     
             $error['message'] = "A custas não pode ser excluída, devido a possuir pagamentos";
             $error['error']   = true;
             
             return $error;
             
         }
         
         $error['message'] = "A custas informada não existe";
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
    public function regraHistorico($idCustas, $dadosAnteriores, $tipoDeUso)
    {
        if(!is_null($idCustas))
        {
            //Obtendo os dados do servico informado
            $custas = Custas::find($idCustas);

            //Caso for usado para obter os dados anteriores
            if($tipoDeUso == 1)
            {
                $data = 
                [
                    //Criando o array com os dados anteriores presentes em Servico
                    'vl_custas'                    => $custas->vl_custas,
                    'nr_parcelas_custas'           => $custas->nr_parcelas_custas,
                    'vl_pago_custas'               => $custas->vl_pago_custas,
                    'dt_calculo_custas'            => $custas->dt_calculo_custas,
                ];
            }
            //Caso for usado para atualizar o historico
            else
            {
                $valorCustasAnterior         = $dadosAnteriores->vl_custas ;
                $nrParcelasAnterior          = $dadosAnteriores->nr_parcelas_custas ;
                $valorPagoAnterior           = $dadosAnteriores->vl_pago_custas ;
                $dataCalculoAnterior         = $dadosAnteriores->dt_calculo_custas ;

                //Obtendo os dados após a atualização
                $valorCustasAtualizado         = $custas->vl_custas ;
                $nrParcelasAtualizado          = $custas->nr_parcelas_custas ;
                $valorPagoAtualizado           = $custas->vl_pago_custas ;
                $dataCalculoAtualizado         = $custas->dt_calculo_custas ;

                $data = [
                    'vl_anterior'                => $valorCustasAnterior,
                    'vl_novo'                    => $valorCustasAtualizado,
                    'nr_parcelas_anterior'       => $nrParcelasAnterior,
                    'nr_parcelas_novo'           => $nrParcelasAtualizado,
                    'vl_pago_anterior'           => $valorPagoAnterior,
                    'vl_pago_novo'               => $valorPagoAtualizado,
                    'dt_calculo_anterior'        => $dataCalculoAnterior,
                    'dt_calculo_novo'            => $dataCalculoAtualizado,
                    'ds_id_origem'               => $idCustas,
                    'ds_tipo_origem'             => 'App\Models\Custas',
                ];
                //grava o historico
                $historicoCustas = $this->find($idCustas);
                $historicoCustas->historicoCustas()->create($data);
            }

            return $data;
        }

        $error['message'] = "A Custas, Multa ou Pecunia informada não existe";
        $error['error']   = true;

        return $error;

    }



}
