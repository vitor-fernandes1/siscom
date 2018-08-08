<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class EnderecoResource extends Resource
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
        'id'               => $this->pk_endereco,
        'logradouro'       => $this->ds_logradouro_endereco,
        'bairro'           => $this->ds_bairro_endereco,
        'complemento'      => $this->ds_complemento_endereco,
        'localidade'       => $this->ds_localidade_endereco,
        'uf'               => $this->ds_uf_endereco,
        'cep'              => $this->ds_cep_endereco,
        'origem'           => $this->ds_id_endereco,
        'origemId'         => $this->ds_tipo_endereco,
        'data_cadastro'    => $this->dt_cadastro_endereco,
        'data_atualizacao' => $this->dt_atualizacao_endereco,
        'data_exclusao'    => $this->dt_exclusao_endereco
        ];
    }
}
