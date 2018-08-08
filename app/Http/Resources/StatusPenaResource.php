<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class StatusPenaResource extends Resource
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
            'id'               => $this->pk_status_pena,
            'nome'             => $this->nm_status_pena,
            'data_cadastro'     => $this->dt_cadastro_status_pena,
            'data_atualizacao' => $this->dt_atualizacao_status_pena,
            'data_exclusao'    => $this->dt_exclusao_status_pena,
        ];
    }
}
