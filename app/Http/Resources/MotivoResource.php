<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MotivoResource extends Resource
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
            'id'        => $this->pk_motivo,
            'descricao' => $this->ds_motivo,
            'acao'      => $this->ds_acao_motivo ,
            'origem'    => $this->ds_tipo_motivo,
            'origemId'  => $this->ds_id_motivo,
            'data'      => $this->dt_cadastro_motivo,    
        ];
    }
}
