<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class OpcaoParametroResource extends Resource
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
            'id'               => $this->pk_opcao_parametro,
            'ativo'            => $this->ds_ativo_opcao_parametro,
            'idOpcao'          => $this->fk_pk_opcao,
            'idParametro'      => $this->fk_pk_parametro,
// 11/05/2018 - Marcelo
// implementando a sugest�o do Paulo: em vez de trazer a ID tr�s o valor correspondente
//'idOpcao'          => new OpcaoResource::collection($this->opcao),
//            'idParametro'      => new Parametro::collection($this->parametro),
            'idOrigem'         => $this->ds_id_opcao_parametro,
            'Origem'           => $this->ds_tipo_opcao_parametro,
            'data_cadastro'     => $this->dt_cadastro_opcao_parametro,
            'data_atualizacao' => $this->dt_atualizacao_opcao_parametro,
            'data_exclusao'    => $this->dt_exclusao_opcao_parametro,

        ];
    }
}
