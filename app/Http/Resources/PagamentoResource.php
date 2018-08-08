<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PagamentoResource extends Resource
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
            'id'               => $this->pk_pagamento,
            'data'             => $this->dt_pagamento,
            'valor'            => $this->vl_pago_pagamento,
            'numComprovante'   => $this->nr_comprovante_pagamento,
            'origem'           => $this->ds_tipo_pagamento,
            'origemId'         => $this->ds_id_pagamento,
            'observacoes'      => $this->ds_observacao_pagamento,
            'motivoExclusao'   => $this->ds_exclusao_pagamento,
            'data_cadastro'    => $this->dt_cadastro_pagamento,
            'data_atualizacao' => $this->dt_atualizacao_pagamento,
            'data_exclusao'    => $this->dt_exclusao_pagamento,
        ];
    }
}
