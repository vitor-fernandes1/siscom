<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ManutencaoResource extends Resource
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
            'id'                => $this->pk_manutencao,
            'descricao'         => $this->ds_descricao_manutencao,
            'data'              => $this->dt_manutencao,
            'valor'             => $this->vl_valor_manutencao,
            'tipo'              => $this->fk_pk_tipo_manutencao,
            'prioridade'        => $this->fk_pk_prioridade,
            'situacao'          => $this->fk_pk_situacao,
            'avaliacao'         => $this->fk_pk_avaliacao,
            'empresa'           => $this->fk_pk_empresa,
            'equipamento'       => $this->fk_pk_equipamento,
            'data_cadastro'     => $this->dt_cadastro_apenado,
            'data_atualizacao'  => $this->dt_atualizacao_apenado,
            'data_exclusao'     => $this->dt_exclusao_apenado,   
        ];
    }
}
