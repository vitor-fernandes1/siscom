<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class FrequenciaResource extends Resource
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
            'id'                  => $this->pk_frequencia,
            'dataHoraEntrada'     => $this->hr_entrada_frequencia,
            'dataHoraSaida'       => $this->hr_saida_frequencia,
            'total'               => $this->nr_total_frequencia,
            'sensibilizado'       =>$this->nr_sensibilizado_frequencia,
            'atividadesRealizada' => $this->ds_atividade_frequencia,
            'tipo'                => new TipoFrequenciaResource($this->tipoFrequencia),
            'servico'             => new ServicoResource($this->whenLoaded('servico')),
            'observacoes'         => $this->ds_observacao_frequencia,
            'motivoExclusao'      => $this->ds_exclusao_frequencia,
            'data_cadastro'       => $this->dt_cadastro_frequencia,
            'data_atualizacao'    => $this->dt_atualizacao_frequencia,
            'data_exclusao'       => $this->dt_exclusao_frequencia,
        ];
    }
}
