<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ParametroResource extends Resource
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
            'id'                => $this->pk_parametro,
            'valor'             => $this->ds_parametro,
            'idOpcao'           => $this->fk_pk_opcao,
            'data_cadastro'      => $this->dt_cadastro_parametro,
            'data_atualizacao'  => $this->dt_atualizacao_parametro,
            'data_exclusao'     => $this->dt_exclusao_parametro,
        ];
    }
}
