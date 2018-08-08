<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ServicoResource extends Resource
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
            'id'                  => $this->pk_servico,
            'horasTotais'         => $this->nr_hrs_servico, 
            'minutosPrestados'    => $this->nr_min_prestados_servico,
            'minutosSensibilizados' => $this->nr_min_sensibilizados_servico,
            'horasMin'            => $this->nr_min_hrs_servico, 
            'horasMax'            => $this->nr_max_hrs_servico, 
            'prazoMinCumprimento' => $this->nr_mes_minimo_servico,
            'pena'                => new PenaResource($this->whenLoaded('pena')),
            'entidade'            => new EntidadeResource($this->whenLoaded('entidade')),
            'frequencias'         => FrequenciaResource::collection($this->whenLoaded('frequencias')),
            'ativo'               => $this->ds_ativo_servico,
            'tipoHoras'           => new TipoServicoResource($this->whenLoaded('tipoServico')),
            'observacoes'         => $this->ds_observacao_servico,
            'data_cadastro'       => $this->dt_cadastro_servico,
            'data_atualizacao'    => $this->dt_atualizacao_servico,
            'data_exclusao'          => $this->dt_exclusao_servico,   
        ];
    }
}
