<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TipoServicoResource extends Resource
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
            'id'               => $this->pk_tipo_servico,
            'nome'             => $this->nm_tipo_servico,
            'data_cadastro'     => $this->dt_cadastro_tipo_servico,
            'data_atualizacao' => $this->dt_atualizacao_tipo_servico,
            'data_exclusao'    => $this->dt_exclusao_tipo_servico,
        ];
    }
}
