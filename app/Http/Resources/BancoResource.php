<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BancoResource extends Resource
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
            'id'               => $this->pk_banco,
            'nome'             => $this->nm_banco,
			            'numero'             => $this->nr_banco,
            /*'data_cadastro'     =>$this->dt_cadastro_banco,
            'data_atualizacao' => $this->dt_atualizacao_banco,
            'data_exclusao'    => $this->dt_exclusao_banco,*/
        ];
    }
}
