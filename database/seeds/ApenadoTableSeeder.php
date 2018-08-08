<?php

use Illuminate\Database\Seeder;

use App\Models\Banco;
use App\Models\Entidade;
use App\Models\Endereco;
use App\Models\StatusEntidade;
use App\Models\TipoDocumento;
use App\Models\Apenado;
use App\Models\Vara;
use App\Models\StatusPena;
use App\Models\Pena;
use App\Models\TipoMulta;
use App\Models\Multa;
use App\Models\HistoricoMulta;

use App\Models\Custas;
use App\Models\HistoricoCustas;

use App\Models\TipoPecunia;
use App\Models\Pecunia;
use App\Models\HistoricoPecunia;
use App\Models\Pagamento;

use App\Models\TipoServico;
use App\Models\Servico;
use App\Models\HistoricoServico;
use App\Models\TipoFrequencia;
use App\Models\Frequencia;

use App\Models\Motivo;

use App\Models\Opcao;
use App\Models\Parametro;
use App\Models\OpcaoParametro;





use Faker\Factory as Faker;

class ApenadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //Cria  apenados e depois cria e atrela  processos 1 para cada apenado
        /*factory(Apenado::class, 10)->create()->each(function($apenado){
          $apenado->pena()->save(factory(Pena::class)->make());
        });*/

        $faker = Faker::create();

        $entidade = Entidade::create([
            'fk_pk_status_entidade'   => 1,
			'fk_pk_banco'             => $faker->numberBetween(1, 100),
			'nr_agencia_bancaria'     => $faker->numberBetween(1000,9000),
			'nr_conta_bancaria'       => $faker->numberBetween(10000,90000),
            'nm_entidade'             => $faker->name,
            'ds_ativo_entidade'       => 1,
            'ds_email_entidade'       => $faker->freeEmail,
            'sg_entidade'             => $faker->currencyCode,
            'nm_resp_entidade'        => $faker->company,
            'ds_cargo_resp_entidade'  => $faker->jobTitle,
            'dt_inicio_conv_entidade' => $faker->date,
            'dt_fim_conv_entidade'    => $faker->date,
            'nr_max_prest_entidade'   => $faker->numberBetween(0,100),
            'ds_observacao_entidade'  => $faker->sentence
        ]);
        $this->command->info('Entidade criada');

        //insere varas com o nome mais proximos da realidade
        $vara = Vara::create([
            'nm_vara'            => '99ª Vara',
            'cd_vara'            => '99',
            'cd_secsubsec_vara'  => '3400',
            'nm_responsavel_vara'=> $faker->name,
            'ds_email_vara'      => $faker->safeEmail,
            'ds_telefone_vara'   => $faker->phoneNumber,
            'ds_ativo_vara'      => 1,
        ]);
        $this->command->info('99a Vara criada');

        /** Criação de Apenado, vara e pena */
        $apenado = Apenado::create([
            'nm_apenado'                => 'Jose da Silva',
            // 'fk_pk_tipo_documento'      => $tipoDocumento->pk_tipo_documento,
            'fk_pk_tipo_documento'      => 2,
            'ds_documento_apenado'      => $faker->randomDigitNotNull,
            'ds_tipo_documento_apenado' => $faker->randomDigitNotNull,
            'nm_mae_apenado'            => $faker->name,
            'nm_pai_apenado'            => $faker->name,
        ]);
        $this->command->info('Apenado criado');

        $endereco = Endereco::create([
            'ds_cep_endereco'           => '70070900',
            'ds_logradouro_endereco'    => 'SAU/SUL Quadra 2, Bloco A',
            'ds_complemento_endereco'   => 'Praça dos Tribunais Superiores',
            'ds_bairro_endereco'        => 'Asa Sul',
            'ds_localidade_endereco'    => 'Brasília',
            'ds_uf_endereco'            => 'DF',
            'ds_tipo_endereco'          => 'App\\Models\\Apenado',
            'ds_id_endereco'            => $apenado->pk_apenado,
        ]);
        $this->command->info('Endereco criado');

        $statusPena = StatusPena::create([
            'nm_status_pena' => $faker->name,
        ]);

        $pena = Pena::create([
            'fk_pk_apenado'     => $apenado->pk_apenado,
            'fk_pk_vara'        => $vara->pk_vara,
            'fk_pk_status_pena' => $statusPena->pk_status_pena, 
            'nr_processo_pena'  => $faker->randomNumber,
            'ds_pena'           => $faker->text,
            'ds_ativo_pena'     => 1,

        ]);
        $this->command->info('Pena atrelada a 99a Vara criada');

        $servico = Servico::create([

            'fk_pk_pena'               => $pena->pk_pena,
            'fk_pk_entidade'           => $entidade->pk_entidade,
            // 'fk_pk_tipo_servico'       => $tipoServico->pk_tipo_servico,
            'fk_pk_tipo_servico'       => 1,
            'nr_hrs_servico'           => $faker->randomDigitNotNull,
            'nr_min_hrs_servico'       => $faker->randomDigitNotNull,
            'nr_max_hrs_servico'       => $faker->randomDigitNotNull,
            'nr_min_prestados_servico' => $faker->randomDigitNotNull,
            'ds_ativo_servico'         => 1,
            'ds_observacao_servico'    => $faker->sentence,
            'nr_mes_minimo_servico'    => $faker->randomDigitNotNull,
        ]);
        $this->command->info('Servico 1 criado');

        $servico = Servico::create([

            'fk_pk_pena'               => $pena->pk_pena,
            'fk_pk_entidade'           => $entidade->pk_entidade,
            // 'fk_pk_tipo_servico'       => $tipoServico->pk_tipo_servico,
            'fk_pk_tipo_servico'       => 1,
            'nr_hrs_servico'           => $faker->randomDigitNotNull,
            'nr_min_hrs_servico'       => $faker->randomDigitNotNull,
            'nr_max_hrs_servico'       => $faker->randomDigitNotNull,
            'nr_min_prestados_servico' => $faker->randomDigitNotNull,
            'ds_ativo_servico'         => 1,
            'ds_observacao_servico'    => $faker->sentence,
            'nr_mes_minimo_servico'    => $faker->randomDigitNotNull,
        ]);
        $this->command->info('Servico 2 criado');

        // $banco=Banco::all();
        $banco=Banco::all()->toArray();

        $servico = Servico::create([

            'fk_pk_pena'               => $pena->pk_pena,
            'fk_pk_entidade'           => $entidade->pk_entidade,
            // 'fk_pk_tipo_servico'       => $tipoServico->pk_tipo_servico,
            'fk_pk_tipo_servico'       => 1,
            'nr_hrs_servico'           => $faker->randomDigitNotNull,
            'nr_min_hrs_servico'       => $faker->randomDigitNotNull,
            'nr_max_hrs_servico'       => $faker->randomDigitNotNull,
            'nr_min_prestados_servico' => $faker->randomDigitNotNull,
            'ds_ativo_servico'         => 1,
            'ds_observacao_servico'    => $faker->sentence,
            'nr_mes_minimo_servico'    => $faker->randomDigitNotNull,
        ]);
        $this->command->info('Servico 3 criado');

        $servico = Servico::create([

            'fk_pk_pena'               => $pena->pk_pena,
            'fk_pk_entidade'           => $entidade->pk_entidade,
            // 'fk_pk_tipo_servico'       => $tipoServico->pk_tipo_servico,
            'fk_pk_tipo_servico'       => 1,
            'nr_hrs_servico'           => $faker->randomDigitNotNull,
            'nr_min_hrs_servico'       => $faker->randomDigitNotNull,
            'nr_max_hrs_servico'       => $faker->randomDigitNotNull,
            'nr_min_prestados_servico' => $faker->randomDigitNotNull,
            'ds_ativo_servico'         => 1,
            'ds_observacao_servico'    => $faker->sentence,
            'nr_mes_minimo_servico'    => $faker->randomDigitNotNull,
        ]);
        $this->command->info('Servico 4 criado');

        foreach(range(1, 30) as $i)
        {
            $apenado = Apenado::create([
                'nm_apenado'                => $faker->name,
                // 'fk_pk_tipo_documento'      => $tipoDocumento->pk_tipo_documento,
                'fk_pk_tipo_documento'      => 2,
                'ds_documento_apenado'      => $faker->randomDigitNotNull,
                'ds_tipo_documento_apenado' => $faker->randomDigitNotNull,
                'nm_mae_apenado'            => $faker->name,
                'nm_pai_apenado'            => $faker->name,
            ]);

            $motivoApenado = Motivo::create([
                'ds_motivo'      => $faker->sentence,
                'ds_acao_motivo' => 'Inativar',
                'ds_tipo_motivo' => 'App\Models\Apenado',
                'ds_id_motivo'   =>  $apenado->pk_apenado,
            ]);

            $vara = Vara::create([
                'nm_vara'            => $faker->name,
                'cd_vara'            => $faker->randomDigitNotNull,
                'cd_secsubsec_vara'  => $faker->randomDigitNotNull,
                'nm_responsavel_vara'=> $faker->name,
                'ds_email_vara'      => $faker->safeEmail,
                'ds_telefone_vara'   => $faker->phoneNumber,
                'ds_ativo_vara'      => 1,
            ]);

            $statusPena = StatusPena::create([
                'nm_status_pena' => $faker->name,
            ]);

            $pena = Pena::create([
                
                'fk_pk_apenado'    => $apenado->pk_apenado,
                'fk_pk_vara'       => $vara->pk_vara,
                'fk_pk_status_pena' => $statusPena->pk_status_pena, 
                'nr_processo_pena' => $faker->randomNumber,
                'ds_pena'          => $faker->text,
                'ds_ativo_pena'    => 1,

            ]);

            $statusEntidade = StatusEntidade::create([
                'nm_status_entidade' => $faker->name,
            ]);

            $entidade = Entidade::create([
            //   'fk_pk_status_entidade'   => $statusEntidade->pk_status_entidade,
              'fk_pk_status_entidade'   => 1,
              'nm_entidade'             => $faker->name,
              'ds_ativo_entidade'       => 1,
              'ds_email_entidade'       => $faker->freeEmail,
              'sg_entidade'             => $faker->currencyCode,
              'nm_resp_entidade'        => $faker->company,
              'ds_cargo_resp_entidade'  => $faker->jobTitle,
              'dt_inicio_conv_entidade' => $faker->date,
              'dt_fim_conv_entidade'    => $faker->date,
              'nr_max_prest_entidade'   => $faker->numberBetween(0,100),
              'ds_observacao_entidade'  => $faker->sentence
            ]);

            /*$tipoServico = TipoServico::create([
                'nm_tipo_servico' => $faker->name,
            ]);*/

            $servico = Servico::create([
                'fk_pk_pena'               => $pena->pk_pena,
                'fk_pk_entidade'           => $entidade->pk_entidade,
                // 'fk_pk_tipo_servico'       => $tipoServico->pk_tipo_servico,
                'fk_pk_tipo_servico'       => 1,
                'nr_hrs_servico'           => $faker->randomDigitNotNull,
                'nr_min_hrs_servico'       => $faker->randomDigitNotNull,
                'nr_max_hrs_servico'       => $faker->randomDigitNotNull,
                'nr_min_prestados_servico' => $faker->randomDigitNotNull,
                'ds_ativo_servico'         => 1,
                'ds_observacao_servico'    => $faker->sentence,
                'nr_mes_minimo_servico'    => $faker->randomDigitNotNull,
            ]);

            $historicoServico = HistoricoServico::create([
                'nr_hrs_anterior'                => $faker->randomDigitNotNull,
                'nr_min_prestados_anterior'      => $faker->randomDigitNotNull,
                'nr_min_hrs_anterior'            => $faker->randomDigitNotNull,
                'nr_max_hrs_anterior'            => $faker->randomDigitNotNull,
                'nr_min_sensibilizados_anterior' => $faker->randomDigitNotNull,
                'nr_mes_minimo_anterior'         => $faker->randomDigitNotNull,
                // 'fk_pk_tipo_servico_anterior'    => $tipoServico->pk_tipo_servico,
                'fk_pk_tipo_servico_anterior'    => 1,
                'fk_pk_entidade_anterior'        => $entidade->pk_entidade,
                'nr_hrs_novo'                    => $faker->randomDigitNotNull,
                'nr_min_prestados_novo'          => $faker->randomDigitNotNull,
                'nr_min_hrs_novo'                => $faker->randomDigitNotNull,
                'nr_max_hrs_novo'                => $faker->randomDigitNotNull,
                'nr_min_sensibilizados_novo'     => $faker->randomDigitNotNull,
                'nr_mes_minimo_novo'             => $faker->randomDigitNotNull,
                'fk_pk_servico'                  => $servico->pk_servico,
                // 'fk_pk_tipo_servico_novo'        => $tipoServico->pk_tipo_servico ,
                'fk_pk_tipo_servico_novo'        => 1,
                'fk_pk_entidade_novo'            => $entidade->pk_entidade,
                'ds_usuario_alteracao'           => $faker->userName,  
            ]);    
            /*$tipoFrequencia = TipoFrequencia::create([
                'nm_tipo_frequencia' => $faker->name,
            ]);*/
         
            $frequencia = Frequencia::create([

                'hr_entrada_frequencia'       => $faker->date.' '.$faker->time,
                'hr_saida_frequencia'         => $faker->date.' '.$faker->time,
                'ds_atividade_frequencia'     => $faker->sentence,
                'nr_total_frequencia'         => $faker->randomDigitNotNull, 
                'ds_observacao_frequencia'    => $faker->sentence,
                // 'fk_pk_tipo_frequencia'       => $tipoFrequencia->pk_tipo_frequencia,
                'fk_pk_tipo_frequencia'       => 1,
                'fk_pk_servico'               => $servico->pk_servico
            ]);

            $custas = Custas::create([
                'vl_custas'         => $faker->numberBetween(1000,9000),
                'nr_parcelas_custas'=> $faker->randomDigitNotNull,
                'vl_pago_custas'    => $faker->numberBetween(1000,9000),
                'dt_calculo_custas' => $faker->date.' '.$faker->time,
                'ds_ativo_custas'   => 1,
                'fk_pk_pena'        => $pena->pk_pena,
            ]);


            foreach(range(1,3) as $j)
            {
                $pagamentosCustas = Pagamento::create([
                    'vl_pago_pagamento'        => $faker->numberBetween(1000,9000),
                    'dt_pagamento'             => $faker->date.' '.$faker->time,
                    'nr_comprovante_pagamento' => $faker->numberBetween(1000,9000),
                    //'ref_pagamento'            => $faker->date,
                    'ds_observacao_pagamento'  => $faker->sentence,
                    'ds_tipo_pagamento'        => 'App\Models\Custas',
                    'ds_id_pagamento'          => $custas->pk_custas,
                ]);

                $historicoCustas = HistoricoCustas::create([
                    'nr_parcelas_anterior'=> $faker->randomDigitNotNull,
                    'vl_anterior'         => $faker->numberBetween(1000,9000) , 
                    'vl_pago_anterior'    => $faker->numberBetween(1000,9000),
                    'dt_calculo_anterior' => $faker->date,
                    'nr_parcelas_novo'  => $faker->randomDigitNotNull,
                    'vl_novo'           => $faker->numberBetween(1000,9000),
                    'vl_pago_novo'      => $faker->numberBetween(1000,9000),
                    'fk_pk_custas'      => $custas->pk_custas,
                    'dt_calculo_novo' => $faker->date,
                    'ds_usuario_alteracao'           => $faker->userName,  

                ]);
            }

            $tipoPecunia = TipoPecunia::create([
                'nm_tipo_pecunia' => $faker->name,
            ]);

            $pecunia = Pecunia::create([
                'nr_parcelas_pecunia'       => $faker->randomDigitNotNull,
                'vl_ pecunia'               => $faker->numberBetween(1000,9000),
                'vl_pago_pecunia'           => $faker->numberBetween(1000,9000),
                'nr_dia_vencimento_pecunia' => $faker->randomDigitNotNull,
                'ds_ativo_pecunia'          => 1,
                'fk_pk_banco'               => $faker->numberBetween(1,100),
                'ds_agencia_pecunia'        => $faker->numberBetween(1000,9000),
                'ds_conta_pecunia'          => $faker->numberBetween(1000,9000),
                'ds_observacao_pecunia'     => $faker->sentence,
                'fk_pk_tipo_pecunia'        => $tipoPecunia->pk_tipo_pecunia,
                'fk_pk_pena'                => $pena->pk_pena,
            ]);

            foreach(range(1,3) as $k)
            {
                $pagamentoPecunia = Pagamento::create([
                    'vl_pago_pagamento'       => $faker->numberBetween(1000,9000),
                    'dt_pagamento'            => $faker->date.' '.$faker->time,
                    'nr_comprovante_pagamento'=> $faker->numberBetween(1000,9000),
                    //'ref_pagamento'           => $faker->date,
                    'ds_observacao_pagamento' => $faker->sentence,
                    'ds_tipo_pagamento'       => 'App\Models\Pecunia',
                    'ds_id_pagamento'         => $pecunia->pk_pecunia,
                ]);

                $historicoPecunia = HistoricoPecunia::create([

                    'nr_parcelas_anterior'  => $faker->randomDigitNotNull,
                    'vl_anterior'           => $faker->numberBetween(1000,9000) , 
                    'vl_pago_anterior'      => $faker->numberBetween(1000,9000),
                    'nr_dia_vencimento_anterior'=> $faker->randomDigitNotNull,
                    'fk_pk_banco_anterior'     => $faker->sentence,
                    'ds_agencia_anterior'   => $faker->numberBetween(1000,9000),
                    'ds_conta_anterior'     => $faker->numberBetween(1000,9000),
                    
                    'nr_parcelas_novo'      => $faker->randomDigitNotNull,
                    'vl_novo'               => $faker->numberBetween(1000,9000),
                    'vl_pago_novo'          =>  $faker->numberBetween(1000,9000),
                    'nr_dia_vencimento_novo'    => $faker->randomDigitNotNull,
                    'fk_pk_banco_novo'         => $faker->sentence,
                    'ds_agencia_novo'       => $faker->numberBetween(1000,9000),
                    'ds_conta_novo'         => $faker->numberBetween(1000,9000),
                    'fk_pk_pecunia'         => $pecunia->pk_pecunia,
                    'ds_usuario_alteracao'  => $faker->userName,  
                ]);
            }

            /*$tipoMulta = TipoMulta::create([
                'nm_tipo_multa' => $faker->name,
            ]);*/

            $multa = Multa::create([
                'vl_multa'          => $faker->numberBetween(1000,9000),
                'nr_parcelas_multa' => $faker->randomDigitNotNull,
                'vl_multa_pago'     => $faker->numberBetween(1000,9000),
                'fk_pk_banco'    => $faker->numberBetween(1,100),
                'ds_agencia_multa'   => $faker->numberBetween(1000,9000),
                'ds_conta_multa'     => $faker->numberBetween(1000,9000),
                'ds_observacao_multa'=> $faker->sentence,
                'ds_ativo_multa'     => 1,
                'dt_calculo_multa'   => $faker->date.' '.$faker->time,
                'fk_pk_pena'         => $pena->pk_pena,
                // 'fk_pk_tipo_multa'   => $tipoMulta->pk_tipo_multa,
                'fk_pk_tipo_multa'   => 2,
            ]);


            foreach(range(1,3) as $j)
            {
                $pagamentoMulta = Pagamento::create([
                    'vl_pago_pagamento'        => $faker->numberBetween(1000,9000),
                    'dt_pagamento'             => $faker->date.' '.$faker->time,
                    'nr_comprovante_pagamento' => $faker->numberBetween(1000,9000),
                    //'ref_pagamento'            => $faker->date,
                    'ds_observacao_pagamento'  => $faker->sentence,
                    'ds_tipo_pagamento'        => 'App\Models\Multa',
                    'ds_id_pagamento'          => $multa->pk_multa,
                ]);

                $historicoMulta = HistoricoMulta::create([
                    // 'fk_pk_tipo_multa_anterior' => $tipoMulta->pk_tipo_multa,
                    'fk_pk_tipo_multa_anterior' => 2,
                    'vl_anterior'          => $faker->numberBetween(1000,9000), 
                    'nr_parcelas_anterior' => $faker->randomDigitNotNull,
                    'vl_pago_anterior'     => $faker->numberBetween(1000,9000),
                    'dt_calculo_anterior'  => $faker->date, 
                    'fk_pk_banco_anterior'    => $faker->sentence,
                    'ds_agencia_anterior'  => $faker->numberBetween(1000,9000),
                    'ds_conta_anterior'    => $faker->numberBetween(1000,9000),
                    // 'fk_pk_tipo_multa_novo' => $tipoMulta->pk_tipo_multa,
                    'fk_pk_tipo_multa_novo' => 2,
                    'vl_novo'             => $faker->numberBetween(1000,9000),
                    'nr_parcelas_novo'    => $faker->randomDigitNotNull,
                    'vl_pago_novo'        => $faker->numberBetween(1000,9000), 
                    'dt_calculo_novo' => $faker->date, 
                    'fk_pk_banco_novo'       => $faker->sentence,
                    'ds_agencia_novo'     => $faker->numberBetween(1000,9000),
                    'ds_conta_novo'       => $faker->numberBetween(1000,9000),
                    'fk_pk_multa'         => $multa->pk_multa,
                    'ds_usuario_alteracao'  => $faker->userName,  

                ]);
            }
            $this->command->info('Conjunto ficticio '.$i.' criado');
        }
    }
}
