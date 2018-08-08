<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Resources\Json\Resource;

class EntidadeResource extends Resource
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
            'id'                       => $this->pk_entidade,
            'status'                   => $this->fk_pk_status_entidade,
            'ativo'                    => $this->ds_ativo_entidade,
            'nome'                     => $this->nm_entidade,
            'sigla'                    => $this->sg_entidade,
            'tipoEntidade'             => $this->when($true=true, $this->obterParametros('tipoEntidade')),
            'enderecos'                => EnderecoResource::collection($this->enderecos), // TODO: Verificar se funciona
            //'telefones'              => , // TODO: Implementar "telefones" em Entidade, array de string
            'email'                    => $this->ds_email_entidade,
            'nomeResponsavel'          => $this->nm_resp_entidade,
            'telefone'                 => $this->ds_telefone_entidade,
            'cargoResponsavel'         => $this->ds_cargo_resp_entidade,
            'dataInicioConvenio'       => $this->dt_inicio_conv_entidade,
            'dataFimConvenio'          => $this->dt_fim_conv_entidade,
            'capacidadeMaxPrestadores' => $this->nr_max_prest_entidade,
            //'enderecosPrestacaoServico' => , // TODO: Avaliar sobre uso de endereço de prestação de serviço
			'atividades'               => OpcaoParametroResource::collection($this->whenLoaded('atividades')), // FIXME: possivelmente não funciona
            'banco'                    => new BancoResource($this->banco),
			'agencia'                  => $this->nr_agencia_bancaria,
			'conta'                    => $this->nr_conta_bancaria,
            'observacoes'              => $this->ds_observacao_entidade,
            'servicos'                 => ServicoResource::collection($this->whenLoaded('servicos')),
            'turnosHabilitados'        => $this->when($true=true, $this->obterParametros('turnosHabilitados')),
            'tiposHabilitados'         => $this->when($true=true, $this->obterParametros('tiposHabilitados')),
            'periodosHabilitados'      => $this->when($true=true, $this->obterParametros('periodosHabilitados')),
            'beneficiosOferecidos'     => $this->when($true=true, $this->obterParametros('beneficiosOferecidos')),
            'data_cadastro'            => $this->dt_cadastro_entidade,
            'data_atualizacao'         => $this->dt_atualizacao_entidade,
            'data_exclusao'            => $this->dt_exclusao_entidade
        ];
    }
}
