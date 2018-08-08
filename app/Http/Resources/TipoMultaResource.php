<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TipoMultaResource extends Resource
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
            'id'               => $this->pk_tipo_multa,
            'nome'             => $this->nm_tipo_multa,
            /*'data_cadastro'     =>$this->dt_cadastro_tipo_multa,
            'data_atualizacao' => $this->dt_atualizacao_tipo_multa,
            'data_exclusao'    => $this->dt_exclusao_tipo_multa,*/
        ];
    }
}
