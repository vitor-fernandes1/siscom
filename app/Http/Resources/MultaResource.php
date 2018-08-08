<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MultaResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'               => $this->pk_multa,
            'pena'             => new PenaResource($this->pena),
            'valorTotal'       => $this->vl_multa,
            'valorPago'        => $this->vl_multa_pago,
            'qtdeParcelas'     => $this->nr_parcelas_multa,
            'tipo'             => new TipoMultaResource($this->tipoMulta),
            'pagamentos'       => PagamentoResource::collection($this->pagamentos),
            'ativo'            => $this->ds_ativo_multa,
            'dataCalculo'      => $this->dt_calculo_multa,
            // 'banco'            => $this->fk_pk_banco,
            'banco'            => new BancoResource($this->banco),
            'agencia'          => $this->ds_agencia_multa,
            'conta'            => $this->ds_conta_multa,
            'observacoes'      => $this->ds_observacao_multa,
            'data_cadastro'    => $this->dt_cadastro_multa,
            'data_atualizacao' => $this->dt_atualizacao_multa,
            'data_exclusao'    => $this->dt_exclusao_multa,
        ];
    }
}
