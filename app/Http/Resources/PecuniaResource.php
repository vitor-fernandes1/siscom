<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PecuniaResource extends Resource
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
            'id'               => $this->pk_pecunia,
            'diaVencimento'    => $this->nr_dia_vencimento_pecunia,
            'valorTotal'       => $this->vl_pecunia,
            'valorPago'        => $this->vl_pago_pecunia,
            'qtdeParcelas'     => $this->nr_parcelas_pecunia,
            'pena'             => new PenaResource($this->pena),
            'banco'            => new BancoResource($this->banco),
            'agencia'          => $this->ds_agencia_pecunia,
            'conta'            => $this->ds_conta_pecunia,
            'entidade'         => new EntidadeResource($this->entidade),
            'pagamentos'       => PagamentoResource::collection($this->whenLoaded('pagamentos')),
            'ativo'            => $this->ds_ativo_pecunia,
            'tipo'             => new TipoPecuniaResource($this->tipoPecunia),
            'observacoes'      => $this->ds_observacao_pecunia,
            'data_cadastro'    => $this->dt_cadastro_pecunia,
            'data_atualizacao' => $this->dt_atualizacao_pecunia,
            'data_exclusao'    => $this->dt_exclusao_pecunia,
        ];
    }
}
