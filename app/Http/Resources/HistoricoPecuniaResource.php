<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class HistoricoPecuniaResource extends Resource
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

           'id'                     => $this->pk_historico_pecunia,
           'pecuniaId'              => $this->fk_pk_pecunia,
           'idOrigem'               => $this->ds_id_origem,
           'origem'                 => $this->ds_tipo_origem,

           'qtdeParcelasAnterior'   => $this->nr_parcelas_anterior,
           'valorPecuniaAnterior'   => $this->vl_anterior,
           'valorPagoAnterior'      => $this->vl_pago_anterior,
           'dataVencimentoAnterior' => $this->dt_vencimento_anterior,

           'qtdeParcelasNovo'       => $this->nr_parcelas_novo,
           'valorPecuniaNovo'       => $this->vl_novo,
           'valorPagoNovo'          => $this->vl_pago_novo,
           'dataVencimentoNovo'     => $this->dt_vencimento_novo,

           'ds_usuario_alteracao',

        ];

    }
}
