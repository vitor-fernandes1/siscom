<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ApenadoResource extends Resource
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
            'id'                => $this->pk_apenado,
            'nome'              => $this->nm_apenado,
            'documento'         => $this->ds_documento_apenado,
            'tipoDocumento'     => new TipoDocumentoResource($this->tipoDocumento),
            'descricaoDocumento'=> $this->ds_tipo_documento_apenado,
            'nomeMae'           => $this->nm_mae_apenado,
            'nomePai'           => $this->nm_pai_apenado,
            'enderecos'          => EnderecoResource::collection($this->enderecos),
            'data_cadastro'     => $this->dt_cadastro_apenado,
            'data_atualizacao'  => $this->dt_atualizacao_apenado,
            'data_exclusao'     => $this->dt_exclusao_apenado,   
        ];
    }
}
