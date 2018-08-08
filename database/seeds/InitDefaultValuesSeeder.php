<?php

use Illuminate\Database\Seeder;

use App\Models\Vara;

use App\Models\Opcao;
use App\Models\Parametro;
use App\Models\OpcaoParametro;

use App\Models\StatusEntidade;
use App\Models\StatusPena;

use App\Models\TipoFrequencia;
use App\Models\TipoServico;
use App\Models\TipoMulta;
use App\Models\TipoDocumento;
use App\Models\TipoPecunia;

class InitDefaultValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vara = Vara::create([
            'nm_vara'            => '10ª Vara',
            'cd_vara'            => '10',
            'cd_secsubsec_vara'  => '3400',
            'nm_responsavel_vara'=> 'Rosires Do Socorro Boas',
            'ds_email_vara'      => '12vara@df.trf1.gov.br',
            'ds_telefone_vara'   => '(61) 3521-3654',
            'ds_ativo_vara'      => 1,
        ]);
        $this->command->info('10a Vara criada');

        $vara = Vara::create([
            'nm_vara'            => '12ª Vara',
            'cd_vara'            => '12',
            'cd_secsubsec_vara'  => '3400',
            'nm_responsavel_vara'=> 'Marcelo Cardinali Braga',
            'ds_email_vara'      => '10vara@df.trf1.gov.br',
            'ds_telefone_vara'   => '(61) 3521-3677',
            'ds_ativo_vara'      => 1,
        ]);
        $this->command->info('12a Vara criada');

        // Status de Pena
        $statusPena = StatusPena::create([
            'nm_status_pena' => 'andamento',
        ]);
        $statusPena = StatusPena::create([
            'nm_status_pena' => 'verificacao',
        ]);
        $statusPena = StatusPena::create([
            'nm_status_pena' => 'concluida',
        ]);
        $this->command->info('Status de Penas criado');

        // Status de Entidade
        $statusEntidade = StatusEntidade::create([
            'nm_status_entidade' => 'sem_convenio',
        ]);
        $statusEntidade = StatusEntidade::create([
            'nm_status_entidade' => 'analise',
        ]);
        $statusEntidade = StatusEntidade::create([
            'nm_status_entidade' => 'aprovada',
        ]);
        $statusEntidade = StatusEntidade::create([
            'nm_status_entidade' => 'rejeitada',
        ]);
        $this->command->info('Status de Entidade criado');

        //Tipo de Frequencia
        $tipoFrequencia = TipoFrequencia::create([
            'nm_tipo_frequencia' => 'Diária',
        ]);

        $tipoFrequencia = TipoFrequencia::create([
            'nm_tipo_frequencia' => 'Mensal',
        ]);
        $this->command->info('Tipo de Frequencia criado');

        //Tipo de Serviço
        $tipoServico = TipoServico::create([
            'nm_tipo_servico' => 'Semanal',
        ]);

        $tipoServico = TipoServico::create([
            'nm_tipo_servico' => 'Mensal',
        ]);
        $this->command->info('Tipo de Serviço criado');

        //Tipo de Multa
        $tipoMulta = TipoMulta::create([
            'nm_tipo_multa' => 'Multa substitutiva',
        ]);

        $tipoMulta = TipoMulta::create([
            'nm_tipo_multa' => 'Pena de multa',
        ]);
        $this->command->info('Tipo de Multa criada');

        //Tipo de Documento
        $tipoDocumento = TipoDocumento::create([
            'nm_tipo_documento' => 'CPF',
        ]);

        $tipoDocumento = TipoDocumento::create([
            'nm_tipo_documento' => 'RG',
        ]);

        $tipoDocumento = TipoDocumento::create([
            'nm_tipo_documento' => 'CNH',
        ]);

        $tipoDocumento = TipoDocumento::create([
            'nm_tipo_documento' => 'Título Eleitoral',
        ]);

        $tipoDocumento = TipoDocumento::create([
            'nm_tipo_documento' => 'Registro Profissional',
        ]);

        $tipoDocumento = TipoDocumento::create([
            'nm_tipo_documento' => 'Carteira Funcional',
        ]);

        $tipoDocumento = TipoDocumento::create([
            'nm_tipo_documento' => 'Passaporte',
        ]);

        $tipoDocumento = TipoDocumento::create([
            'nm_tipo_documento' => 'Estrangeiro',
        ]);
        $this->command->info('Tipo de Documento criado');
        
        //Tipo de Pecúnia
        $tipoPecunia = TipoPecunia::create([
            'nm_tipo_pecunia' => 'Doação para Entidade',
        ]);
        $tipoPecunia = TipoPecunia::create([
            'nm_tipo_pecunia' => 'Pagamento em Juízo',
        ]);
        $this->command->info('Tipo de Pecunia criado');

        /*** Opções em Entidade ***/
         // adicionar tipoEntidade
        $opcao = Opcao::create([
            'ds_opcao' => 'tipoEntidade',
        ]);

        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'matriz',
        ]);
        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'filial',
        ]);
        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'patronado',
        ]);
        $this->command->info('Entidade - Tipo Entidade criado'); 

        // adicionar tiposHabilitados
        $opcao = Opcao::create([
            'ds_opcao' => 'tiposHabilitados',
        ]);

        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'prestação pecuniária',
        ]);
        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'prestação de serviço',
        ]);
        $this->command->info('Entidade - Tipos Habilitados criado');

        // adicionar periodosHabilitados
        $opcao = Opcao::create([
            'ds_opcao' => 'periodosHabilitados',
        ]);

        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'dias úteis',
        ]);
        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'sábados',
        ]);
        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'domingos',
        ]);
        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'feriados',
        ]);
        $this->command->info('Entidade - Períodos Habilitados criado');

        // adicionar turnosHabilitados
        $opcao = Opcao::create([
            'ds_opcao' => 'turnosHabilitados',
        ]);

        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'manhã',
        ]);
        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'tarde',
        ]);
        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'noite',
        ]);
        $this->command->info('Entidade - Turnos Habilitados criado'); 

        // adicionar beneficiosOferecidos
        $opcao = Opcao::create([
            'ds_opcao' => 'beneficiosOferecidos',
        ]);

        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'ticket',
        ]);
        $parametro = Parametro::create([
            'fk_pk_opcao' => $opcao->pk_opcao,
            'ds_parametro' => 'vale-transporte',
        ]);
        $this->command->info('Entidade - Beneficos Oferecidos criado'); 

        // TODO: adicionar atividadesDisponiveis (atualimente e´ array de strings)
    }
}
