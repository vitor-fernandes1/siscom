<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Pagamento extends Model
{
    use SoftDeletes;

    /**
     * <b>CREATED_AT</b> Renomeia o campo padrão created_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const CREATED_AT = 'dt_cadastro_pagamento';

    /**
     * <b>UPDATED_AT</b>  Renomeia o campo padrão updated_at criado por padrão quando utilizamos o metodo timestamps() na migration
    */
    const UPDATED_AT = 'dt_atualizacao_pagamento';

    /**
     * <b>DELETED_AT</b> Renomeia o campo padrão deleted_at criado por padrão quando utilizamos a Trait SoftDeletes na model
     * OBS: Essa trait habilita a exclusão logica de registros nativa do Laravel
    */
    const DELETED_AT = 'dt_exclusao_pagamento';


    /**
     * <b>primaryKey</b> Informa qual a é a chave primaria da tabela
    */
    protected $primaryKey = "pk_pagamento";

    /**
     * <b>dates</b> Serve para tratar todos os campos de data para serem também um objeto do tipo Carbon(biblioteca de datas)
    */
    protected $dates = ['dt_pagamento', 'dt_cadastro_pagamento', 'dt_atualizacao_pagamento', 'dt_exclusao_pagamento'];

    /**
     * <b>fillable</b> Informa quais colunas é permitido a inserção de dados (MassAssignment)
     *
    */
    protected $fillable=[ 'vl_pago_pagamento',
                          'dt_pagamento',
                          'nr_comprovante_pagamento',
                          'ds_observacao_pagamento',
                          'ds_exclusao_pagamento',
                          'ds_id_pagamento',
                          'ds_tipo_pagamento',

                        ];

    /**
     * <b>table</b> Informa qual é a tabela que o modelo irá utilizar
    */
    public $table = "sigmp_pagamento";


    /**
     * <b>rules</b> Atributo responsável em definir regras de validação dos dados submetidos pelo formulário
     * OBS: A validação bail é responsável em parar a validação caso um das que tenha sido especificada falhe
    */

    public $rules = [
        'vl_pago_pagamento'        => 'bail|required',
        'dt_pagamento'             => 'bail|required|date',
        'nr_comprovante_pagamento' => 'bail|required|min:1|max:255',
        'ds_observacao_pagamento'  => 'bail|nullable|min:5|max:255',
        'ds_exclusao_pagamento'    => 'bail|nullable|min:5|max:255',
        'ds_id_pagamento'          => 'bail|required|numeric',
        'ds_tipo_pagamento'        => 'bail|required',
        'dt_cadastro_pagamento'    => 'bail|date',
        'dt_atualizacao_pagamento' => 'bail|date',
        'dt_exclusao_pagamento'    => 'bail|date',
    ];

    /**
     * <b>messages</b>  Atributo responsável em definir mensagem de validação de acordo com as regras especificadas no atributo $rules
    */
    public $messages = [
        'vl_pago_pagamento.required'        => 'O campo valor é obrigatório !',
        'dt_pagamento.required'             => 'O campo data é obrigatório !',
        'dt_pagamento.date'                 => 'O campo data pagamento deve ser uma data válida!',
        'nr_comprovante_pagamento.required' => 'O campo numComprovante é obrigatório !',
        'nr_comprovante_pagamento.min'      => 'O campo numComprovante deve conter pelo menos 5 caracteres!',
        'nr_comprovante_pagamento.max'      => 'O campo numComprovante deve conter até 255 caracteres!',
        'ds_observacao_pagamento.min'       => 'O campo observacoes deve conter pelo menos 5 caracteres!',
        'ds_observacao_pagamento.max'       => 'O campo observacoes deve conter até 255 caracteres!',
        'ds_exclusao_pagamento.min'         => 'O campo motivoExclusao deve conter pelo menos 5 caracteres!',
        'ds_exclusao_pagamento.max'         => 'O campo motivoExclusao deve conter até 255 caracteres!',
        'ds_id_pagamento.required'          => 'O campo origimId do Pagamento é obrigatório !',
        'ds_id_pagamento.numeric'           => 'O campo origimId do Pagamento deve ser númerico!',
        'ds_tipo_pagamento.required'        => 'O campo origem do Pagamento é obrigatório !',

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
    public $collection = "\App\Http\Resources\PagamentoResource::collection";

    /**
     * <b>resource</b>
    */
    public $resource = "\App\Http\Resources\PagamentoResource";

    /**
     * <b>map</b> Atributo responsável em atribuir um alias(Apelido), para a colunas do banco de dados
     * OBS: este atributo é utilizado no Metodo store e update da ApiControllerTrait
    */
    public $map = [
        'id'                => 'pk_pagamento',
        'data'              => 'dt_pagamento',
        'valor'             => 'vl_pago_pagamento',
        'numComprovante'    => 'nr_comprovante_pagamento',
        'observacoes'       => 'ds_observacao_pagamento',
        'origem'            => 'ds_tipo_pagamento',
        'origemId'          => 'ds_id_pagamento',
        'motivoExclusao'    => 'ds_exclusao_pagamento',
        'data_cadastro'     => 'dt_cadastro_pagamento',
        'data_atualizacao'  => 'dt_atualizacao_pagamento',
        'data_exclusao'     => 'dt_exclusao_pagamento',
    ];

    /**
     * <b>aliasMorph</b> Atributo responsável em associar o tipo de pagamento ao namespace correto da classe (Multa ou Pecunia)
     */
    public $aliasMorph = [
        'custas' => 'App\Models\Custas',
        'multa'   => 'App\Models\Multa',
        'pecunia' => 'App\Models\Pecunia',
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
     * <b>setVlPagoPagamentoAttribute</b> Mutator que faz o tratamento antes do valor ser gravado no banco de dados
     * grava o valor substituindo a ,(virgula) por "nada" (vazio)
     * OBS: Mutator: Funções do model que modifica a informação antes ser gravada para o banco de dados
     */
    public function setVlPagoPagamentoAttribute($value)
    {

        $this->attributes['vl_pago_pagamento'] = str_replace(',', '', $value);

    }

    /**
     * <b>getVlPagoPagamentoAttribute</b> Apresenta o valor com a ,(virgula) na casa do milhar e com .(ponto) na casa das dezenas
     * Exemplo: 5,600.48
     * OBS: Accesor: Funções do model que modifica a informação que vem do banco de dados antes de ser apresentada para o usuário
     */
    public function getVlPagoPagamentoAttribute($value)
    {

        if(isset($value))
        {
            return money_format('%i', $value);
            //return number_format($value, 2, ".", ",");
        }
        return false;
    }

    /**
     * <b>pagamentoable</b>  Método responsável em definir o nome do relacionamento polimorfico (polymorphic) e o nome da coluna tipo.
     * No caso especifico deste relacionamento, quem irá utilizar o mesmo será a model de Pecunia e Pagamento
     */
    /*public function pagamentoable()
    {
        return $this->morphTo('pagamentoable','pagamentoable_tipo');
    }*/

    public function dsTipoPagamento()
    {
        return $this->morphTo();
    }


    /**
     * **************************************************
     * ********** R E G R A S  D E  N E G O C I O *******
     * **************************************************
    */

    /**
     * <b>regraHistorico</b> Método responsável  em verificar qual é o tipo de pagamento (Multa ou Pecunia) e realizar a gravação
     * de seu respectivo historico, apartir a criação de um pagamento.
     * @param $data (dados a serem gravados no histórico)
     * @param $id   (id da multa ou pecunia)
     * @param $type (tipo multa ou pecunia)
     * @return $historico ou error
    */

    public function regraHistorico($valorPagoCadastradoAnterior, $request, $type, $IdPagamento)
    {
        //obtendo id do servico
        $id = $request->origemId ;
        $tiposPagamentos = $this->aliasMorph;
        //$class = $tiposPagamentos[$type];
        $class = $this->regraTipo($type);

        if($class)

        {
            $query = $class::find($id);

            if(! is_null($query))

            {
                if($type == "App\Models\Custas")
                {
                    //Obtendo os valores pagos atualizados
                    $dadosDoPagamentoAtualizado = Custas::find($IdPagamento);
                    $valorPagoAtualizado = $dadosDoPagamentoAtualizado->vl_pago_custas;

                    
                    $query = (Object)  $query;
                    $data['ds_id_origem'] = $IdPagamento;
                    $data['ds_tipo_origem'] = "App\Models\Pagamento";
                    $data['vl_pago_novo'] = $valorPagoAtualizado ;
                    $data['vl_pago_anterior'] = $valorPagoCadastradoAnterior;
                    $query->historicoCustas()->create($data);
                }

                if($type == "App\Models\Multa")
                {
                    //Obtendo os valores pagos atualizados
                    $dadosDoPagamentoAtualizado = Multa::find($IdPagamento);
                    $valorPagoAtualizado = $dadosDoPagamentoAtualizado->vl_multa_pago;

                    $query = (Object)  $query;
                    $data['ds_id_origem'] = $IdPagamento;
                    $data['ds_tipo_origem'] = "App\Models\Pagamento";
                    $data['vl_pago_novo'] = $valorPagoAtualizado ;
                    $data['vl_pago_anterior'] = $valorPagoCadastradoAnterior;
                    $query->historicoMultas()->create($data);
                }

                if($type == "App\Models\Pecunia")
                {
                    //Obtendo os valores pagos atualizados
                    $dadosDoPagamentoAtualizado = Pecunia::find($IdPagamento);
                    $valorPagoAtualizado = $dadosDoPagamentoAtualizado->vl_pago_pecunia;

                    $query = (Object)  $query;
                    $data['ds_id_origem'] = $IdPagamento;
                    $data['ds_tipo_origem'] = "App\Models\Pagamento";
                    $data['vl_pago_novo'] = $valorPagoAtualizado ;
                    $data['vl_pago_anterior'] = $valorPagoCadastradoAnterior;
                    $query->historicoPecunias()->create($data);

                }

                return $query;

            }


        }

        $error['message'] = "A Custas, Multa ou Pecunia informada não existe";
        $error['error']   = true;

        return $error;

    }


    /**
     * <b>regraSaldo</b> Método responsável em atualizar o montante pago sendo o mesmo da Multa ou Pecunia
     *
     * @param int $id   (id da multa ou pecunia)
     * @param int $value (O valor pago)
     * @param string $type (tipo multa ou pecunia)
     * @param bollean $excluir (recebe null para pagamento e true para debito de pagamento)
     * @return $saldo ou error
    */

    public function regraSaldo($id, $value, $type, $excluir = null)
    {
        $tiposPagamentos = $this->aliasMorph;
        //$class = $tiposPagamentos[$type];
        $class = $this->regraTipo($type);

        if($class)
        {
            $query = $class::find($id);

            if(! is_null($query))
            {

                if($type == "custas" || $type == $this->aliasMorph["custas"])
                {
                    $query = (Object) $query;

                    $saldoAtual = is_null($excluir) ?   str_replace(',', '',$query->vl_pago_custas) + $value :  str_replace(',', '',$query->vl_pago_custas) - $value;

                    $data = ['vl_pago_custas' => $saldoAtual];

                }

                if($type == "multa" || $type == $this->aliasMorph["multa"])
                {
                     $query = (Object) $query;

                     $saldoAtual = is_null($excluir) ?   str_replace(',', '',$query->vl_multa_pago) + $value :  str_replace(',', '',$query->vl_multa_pago) - $value;

                     $data = ['vl_multa_pago' => $saldoAtual];

                }

                if($type == "pecunia" || $type == $this->aliasMorph["pecunia"])
                {
                    $query = (Object) $query;

                    $saldoAtual = is_null($excluir) ?   str_replace(',', '',$query->vl_pago_pecunia) + $value :  str_replace(',', '',$query->vl_pago_pecunia) - $value;

                    $data = ['vl_pago_pecunia' => $saldoAtual];

                }

                $query->update($data);
                return $query;
            }

        }

        $error['message'] = "A Custas, Multa ou Pecunia informada não existe";
        $error['error']   = true;

        return $error;

    }



    /**
     * <b>regraTipo</b> Método responsável em retornar o namespace da classe responsável pelo pagamento que esta sendo realizado
     * @param $type (tipo multa ou pecunia ou o valor do namespace exemplo App\Models\Pecunia)
     * @return $tiposPagamentos(namespace da classe responsavel Multa ou Pecunia) ou $error
    */

    public function regraTipo($type)
    {
        $tiposPagamentos = $this->aliasMorph;

        $indice = array_key_exists($type, $tiposPagamentos);
        $valor  = in_array($type, $tiposPagamentos);
        
        if(empty($indice) && empty($valor))
        {
            $error['message'] = "A Custas, Multa ou Pecunia informada não existe";
            $error['error']   = true;

            return $error;

        }
        elseif(empty($valor))
        {
            return $tiposPagamentos[$type];
        }
        /*elseif($valor)
        {
            return array_search($type, $tiposPagamentos);
        }*/
        else
        {
            return $type;
        }




    }

    /**
     * <b>regraAtivo</b> Método responsável em verificar antes de efetuar o pagamento se uma Custa, Multa ou Pecunia informada
     * existe e se encontra ativa.
     * @param $id   (id da custa, multa ou pecunia)
     * @param $type (tipo custa, multa ou pecunia)
     * @return true (caso a custa, multa ou pecunia exista e esteja ativa) ou $error
     *
    */
    public function regraAtivo($id, $type)
    {

        $tiposPagamentos = $this->aliasMorph;
        //$class = $tiposPagamentos[$type];
        $class = $this->regraTipo($type);//identificar quando a variavel $class recebe um $error

        if($class)
        {
            $query = $class::find($id);

            if(! is_null($query))
            {

              if($type == "custas" || $type == $this->aliasMorph["custas"])
              {

                $count = $query->whereRaw("PK_CUSTAS={$id} AND DS_ATIVO_CUSTAS= 1")->count();

                if($count > 0)
                {
                    return true;
                }

                $error['message'] = "A Custa informada não esta ativa. Ação não permitida !";
                $error['error']   = true;

                return $error;

              }

              if($type == "multa" || $type == $this->aliasMorph["multa"])
              {

                $count = $query->whereRaw("PK_MULTA={$id} AND DS_ATIVO_MULTA= 1")->count();

                {
                    return true;
                }

                $error['message'] = "A Multa informada não esta ativa. Ação não permitida !";
                $error['error']   = true;

                return $error;

              }

              if($type == "pecunia" || $type == $this->aliasMorph["pecunia"])
              {

                $count = $query->whereRaw("PK_PECUNIA={$id} AND DS_ATIVO_PECUNIA= 1")->count();

                if($count > 0)
                {
                    return true;
                }

                $error['message'] = "A Pecunia informada não esta ativa. Ação não permitida !";
                $error['error']   = true;

                return $error;
              }

            }


        }

        $error['message'] = "A Custa, Multa ou Pecunia informada não existe";
        $error['error']   = true;

        return $error;

    }





}
