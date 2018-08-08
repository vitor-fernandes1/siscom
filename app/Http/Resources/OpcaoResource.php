<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class OpcaoResource extends Resource
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
            'id'                => $this->pk_opcao,
            'chave'             => $this->ds_opcao,
            'data_cadastro'      => $this->dt_cadastro_opcao,
            'data_atualizacao'  => $this->dt_atualizacao_opcao,
            'data_exclusao'     => $this->dt_exclusao_opcao,
        ];
    }
}
