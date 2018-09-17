<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class EquipamentoResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            'id'                => $this->pk_equipamento,
            'nome'              => $this->nm_equipamento,
            'dataCompra'        => $this->dt_compra_equipamento,
            'descricao'         => $this->ds_descricao_equipamento,
            'valor'             => $this->nr_valor_equipamento,
            'tipo'              => $this->fk_pk_tipo_equipamento,
            'data_cadastro'     => $this->dt_cadastro_apenado,
            'data_atualizacao'  => $this->dt_atualizacao_apenado,
            'data_exclusao'     => $this->dt_exclusao_apenado,   
        ];
    }
}
