<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class VaraResource extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        

         return  [
            'id'               => $this->pk_vara,
            'nome'             => $this->nm_vara,
            'codigoVara'       => $this->cd_vara,
            'secsubsec'        => $this->cd_secsubsec_vara,
            'contato'          => $this->nm_responsavel_vara,
            'email'            => $this->ds_email_vara,
            'telefone'         => $this->ds_telefone_vara,
            'penas'            => PenaResource::collection($this->whenLoaded('penas')),
            'ativo'            => $this->ds_ativo_vara,
            'data_cadastro'    => $this->dt_cadastro_vara,
            'data_atualizacao' => $this->dt_atualizacao_vara,
            'dt_exclusao'      => $this->dt_exclusao_vara,   
        ];

    }
}
