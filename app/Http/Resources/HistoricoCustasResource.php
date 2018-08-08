<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class HistoricoCustasResource extends Resource
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
            'id'               => $this->pk_historico_custas,
            'custasId'         => $this->fk_pk_custas,
            'usuarioAlteracao'  => $this->ds_usuario_alteracao,
            'idOrigem'          => $this->ds_id_origem,
            'origem'            => $this->ds_tipo_origem,
            'qtdeParcelasAnterior' => $this->nr_parcelas_anterior,
            'valorTotalAnterior'   => $this->vl_anterior,
            'valorPagoAnterior'    => $this->vl_pago_anterior,
            'dataCalculoAnterior'  => $this->dt_calculo_anterior,

            'qtdeParcelasNovo'     => $this->nr_parcelas_novo,
            'valorTotalNovo'       => $this->vl_novo,
            'valorPagoNovo'        => $this->vl_pago_novo,
            'dataCalculoNovo'      => $this->dt_calculo_novo,

            'data_cadastro'        => $this->dt_cadastro_historico_custas,
            'data_atualizacao'     => $this->dt_atualiza_historico_custas,
            'data_exclusao'        => $this->dt_exclusao_historico_custas,
        ];
    }
}
