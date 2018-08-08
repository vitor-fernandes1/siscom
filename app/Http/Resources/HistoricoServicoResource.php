<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class HistoricoServicoResource extends Resource
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

            'id'                          => $this->pk_historico_servico,
            'servico'                   => $this->fk_pk_servico,
            'usuarioAlteracao'            => $this->ds_usuario_alteracao,
            'idOrigem'                    => $this->ds_id_origem,
            'origem'                      => $this->ds_tipo_origem,
            'entidadeAnterior'            => $this->fk_pk_entidade_anterior,
            'tipoHorasAnterior'           => $this->fk_pk_tipo_servico_anterior,
            'horasTotaisAnterior'         => $this->nr_hrs_anterior,
            'horasMinMesAnterior'         => $this->nr_min_hrs_mes_anterior,
            'horasMaxMesAnterior'         => $this->nr_max_hrs_mes_anterior,
            'minutosPrestadosAnterior'    => $this->nr_min_prestados_anterior,
            'minutosSensibilizadosAnterior'=> $this->nr_min_sensibilizados_anterior,
            'prazoMinCumprimentoAnterior' => $this->nr_mes_minimo_anterior,

            'entidadeNovo'                 => $this->fk_pk_entidade_novo,
            'tipoHorasNovo'                => $this->fk_pk_tipo_servico_novo,
            'horasTotaisNovo'              => $this->nr_hrs_novo,
            'horasPrestadasNovo'           => $this->nr_hrs_prestadas_novo,
            'horasMinMesNovo'              => $this->nr_min_hrs_mes_novo,
            'horasMaxMesNovo'              => $this->nr_max_hrs_mes_novo,
            'minutosPrestadosNovo'         => $this->nr_min_prestados_novo,
            'minutosSensibilizadosNovo'    => $this->nr_min_sensibilizados_novo,
            'prazoMinCumprimentoNovo'      => $this->nr_mes_minimo_novo,

            'data_cadastro'                => $this->dt_cadastro_historico_servico,
            'data_atualizacao'             => $this->dt_atualiza_historico_servico,
            'data_exclusao'                => $this->dt_exclusao_historico_servico,


        ];
    }
}
