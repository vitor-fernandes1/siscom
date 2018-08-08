<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TipoDocumentoResource extends Resource
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
            'id'               => $this->pk_tipo_documento,
            'nome'             => $this->nm_tipo_documento,
            /*'data_cadatro'     => $this->dt_cadastro_tipo_documento,
            'data_atualizacao' => $this->dt_atualizacao_tipo_documento,
            'data_exclusao'    => $this->dt_exclusao_tipo_documento,*/
        ];
    }
}
