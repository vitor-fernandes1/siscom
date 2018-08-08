<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PenaResource extends Resource
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
            'id'               => $this->pk_pena,
            'status'           => $this->fk_pk_status_pena,
            'numProcesso'      => $this->nr_processo_pena,
            'descricao'        => $this->ds_pena,
            'apenado'          => new ApenadoResource($this->apenado),
            'servicos'         => ServicoResource::collection($this->whenLoaded('servicos')),
            'pecunias'         => PecuniaResource::collection($this->whenLoaded('pecunias')),
            'multas'           => MultaResource::collection($this->whenLoaded('multas')),
            'custas'           => CustasResource::collection($this->whenLoaded('custas')),
            'ativo'            => $this->ds_ativo_pena,
            'data_cadastro'     => $this->dt_cadastro_pena,
            'data_atualizacao' => $this->dt_atualizacao_pena,
            'data_exclusao'    => $this->dt_exclusao_pena,
        ];
    }
}
