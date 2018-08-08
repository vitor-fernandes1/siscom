<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class StatusEntidadeResource extends Resource
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
            'id'               => $this->pk_status_entidade,
            'nome'             => $this->nm_status_entidade,
            'data_cadastro'     => $this->dt_cadastro_status_entidade,
            'data_atualizacao' => $this->dt_atualizacao_status_entidade,
            'data_exclusao'    => $this->dt_exclusao_status_entidade,
        ];
    }
}
