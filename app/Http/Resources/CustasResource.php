<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CustasResource extends Resource
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
            'id'               => $this->pk_custas,
            'pena'             => new PenaResource($this->pena),
            'valorTotal'       => $this->vl_custas,
            'qtdeParcelas'     => $this->nr_parcelas_custas,
            'valorPago'        => $this->vl_pago_custas,
            'ativo'            => $this->ds_ativo_custas,
            'observacoes'      => $this->ds_observacao_custas,
            'dataCalculo'      => $this->dt_calculo_custas,
            'pagamentos'       => PagamentoResource::collection($this->pagamentos),
            'data_cadastro'     => $this->dt_cadastro_custas,
            'data_atualizacao' => $this->dt_atualizacao_custas,
            'data_exclusao'    => $this->dt_exclusao_custas,
        ];
    }
}
