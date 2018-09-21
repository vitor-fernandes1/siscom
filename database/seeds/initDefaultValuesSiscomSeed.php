<?php

use Illuminate\Database\Seeder;
use App\Models\Equipamento;
use App\Models\Prioridade;
use App\Models\Situacao;
use App\Models\TipoEquipamento;
use App\Models\TipoManutencao;
use App\Models\Empresa;
use App\Models\Avaliacao;
use App\Models\Manutencao;

class initDefaultValuesSiscomSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //TIPO DE EQUIPAMENTOS
        $tipoEquipamento = TipoEquipamento::create([
            'ds_tipo_equipamento'       => 'Eletroeletrônico',
        ]);
        $tipoEquipamento = TipoEquipamento::create([
            'ds_tipo_equipamento'       => 'Eletrônico',
        ]);
        $tipoEquipamento = TipoEquipamento::create([
            'ds_tipo_equipamento'       => 'Elétrico',
        ]);
        $tipoEquipamento = TipoEquipamento::create([
            'ds_tipo_equipamento'       => 'Eletrodoméstico',
        ]);
        
        //PRIORIDADE
        $prioridade = Prioridade::create([
            'ds_prioridade'       => 'Alta',
        ]);
        $prioridade = Prioridade::create([
            'ds_prioridade'       => 'Média',
        ]);
        $prioridade = Prioridade::create([
            'ds_prioridade'       => 'Baixa',
        ]);
        
        //SITUACAO
        $situacao = Situacao::create([
            'ds_situacao'       => 'Em andamento',
        ]);
        $situacao = Situacao::create([
            'ds_situacao'       => 'Pendente',
        ]);
        $situacao = Situacao::create([
            'ds_situacao'       => 'Concluído',
        ]);

        //AVALIACAO
        $avalicao = Avaliacao::create([
            'ds_avaliacao'       => 'Ótimo',
        ]);
        $avalicao = Avaliacao::create([
            'ds_avaliacao'       => 'Médio',
        ]);
        $avalicao = Avaliacao::create([
            'ds_avaliacao'       => 'Ruim',
        ]);

        //TIPOS DE MANUTENCAO
        $tipoManutencao = TipoManutencao::create([
            'ds_tipo_manutencao'       => 'Preventiva',
        ]);
        $tipoManutencao = TipoManutencao::create([
            'ds_tipo_manutencao'       => 'Corretiva',
        ]);
        $tipoManutencao = TipoManutencao::create([
            'ds_tipo_manutencao'       => 'Preditiva',
        ]);
        $tipoManutencao = TipoManutencao::create([
            'ds_tipo_manutencao'       => 'Detectiva',
        ]);

        //EQUIPAMENTOS
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Ar-Condicionado',
            'dt_compra_equipamento'     => '2018-08-05',
            'ds_descricao_equipamento'  => 'Compra realizada por necessidades operacionais',
            'nr_valor_equipamento'      => '1500',
            'fk_pk_tipo_equipamento'    => '1',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Computador',
            'dt_compra_equipamento'     => '2018-08-05',
            'ds_descricao_equipamento'  => '',
            'nr_valor_equipamento'      => '2150',
            'fk_pk_tipo_equipamento'    => '2',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Televisao',
            'dt_compra_equipamento'     => '2018-08-06',
            'ds_descricao_equipamento'  => '',
            'nr_valor_equipamento'      => '3500',
            'fk_pk_tipo_equipamento'    => '2',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Frigobar',
            'dt_compra_equipamento'     => '2018-08-07',
            'ds_descricao_equipamento'  => '',
            'nr_valor_equipamento'      => '1400',
            'fk_pk_tipo_equipamento'    => '4',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Circuito de cameras',
            'dt_compra_equipamento'     => '2018-08-10',
            'ds_descricao_equipamento'  => 'Aumento da segurança',
            'nr_valor_equipamento'      => '5000',
            'fk_pk_tipo_equipamento'    => '2',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Cofre 500tgu',
            'dt_compra_equipamento'     => '2018-08-11',
            'ds_descricao_equipamento'  => 'Aumento da segurança',
            'nr_valor_equipamento'      => '5000',
            'fk_pk_tipo_equipamento'    => '2',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Fechaduras Eletrónicas para Hotéis',
            'dt_compra_equipamento'     => '2018-08-12',
            'ds_descricao_equipamento'  => 'Aumento da segurança',
            'nr_valor_equipamento'      => '5000',
            'fk_pk_tipo_equipamento'    => '2',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Monitor',
            'dt_compra_equipamento'     => '2018-08-13',
            'nr_valor_equipamento'      => '800',
            'fk_pk_tipo_equipamento'    => '2',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Televisão Sony 42 polegadas',
            'dt_compra_equipamento'     => '2018-02-05',
            'nr_valor_equipamento'      => '1980',
            'fk_pk_tipo_equipamento'    => '2',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Monitor Led curvo 30"',
            'dt_compra_equipamento'     => '2018-07-17',
            'nr_valor_equipamento'      => '1580',
            'fk_pk_tipo_equipamento'    => '2',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Ar-Condicionado 9000BTU',
            'dt_compra_equipamento'     => '2018-08-15',
            'ds_descricao_equipamento'  => 'Será instalado na copa',
            'nr_valor_equipamento'      => '3940',
            'fk_pk_tipo_equipamento'    => '3',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Laptop Positivo QuadCore',
            'dt_compra_equipamento'     => '2018-08-20',
            'ds_descricao_equipamento'  => 'De uso da recepção',
            'nr_valor_equipamento'      => '3940',
            'fk_pk_tipo_equipamento'    => '2',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Laptop Lenovo DualCore',
            'dt_compra_equipamento'     => '2018-08-20',
            'ds_descricao_equipamento'  => 'De uso da recepção',
            'nr_valor_equipamento'      => '3940',
            'fk_pk_tipo_equipamento'    => '2',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Modem TP-Link 4g 9 Bandas',
            'dt_compra_equipamento'     => '2018-08-21',
            'nr_valor_equipamento'      => '580',
            'fk_pk_tipo_equipamento'    => '2',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Lavadora Brastemp 11KG 1ªun.',
            'dt_compra_equipamento'     => '2018-08-21',
            'nr_valor_equipamento'      => '1980',
            'fk_pk_tipo_equipamento'    => '4',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Lavadora Brastemp 11KG 2ªun.',
            'dt_compra_equipamento'     => '2018-08-22',
            'nr_valor_equipamento'      => '1980',
            'fk_pk_tipo_equipamento'    => '4',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Lavadora Brastemp 11KG 3ªun.',
            'dt_compra_equipamento'     => '2018-08-23',
            'nr_valor_equipamento'      => '1980',
            'fk_pk_tipo_equipamento'    => '4',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Fogão Industrial',
            'dt_compra_equipamento'     => '2018-09-12',
            'nr_valor_equipamento'      => '4500',
            'fk_pk_tipo_equipamento'    => '4',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Ar-Condicionado 3500BTU 1ªun',
            'dt_compra_equipamento'     => '2018-09-12',
            'nr_valor_equipamento'      => '1560',
            'fk_pk_tipo_equipamento'    => '3',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Ar-Condicionado 3500BTU 2ªun.',
            'dt_compra_equipamento'     => '2018-09-12',
            'nr_valor_equipamento'      => '1560',
            'fk_pk_tipo_equipamento'    => '3',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Ar-Condicionado 3500BTU 3ªun.',
            'dt_compra_equipamento'     => '2018-09-15',
            'nr_valor_equipamento'      => '1560',
            'fk_pk_tipo_equipamento'    => '3',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Ar-Condicionado 3500BTU 4ªun.',
            'dt_compra_equipamento'     => '2018-09-15',
            'nr_valor_equipamento'      => '1560',
            'fk_pk_tipo_equipamento'    => '3',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Minibar 26L 1ªun.',
            'dt_compra_equipamento'     => '2018-09-15',
            'nr_valor_equipamento'      => '1789',
            'fk_pk_tipo_equipamento'    => '4',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Minibar 20L 1ªun.',
            'dt_compra_equipamento'     => '2018-09-15',
            'nr_valor_equipamento'      => '1789',
            'fk_pk_tipo_equipamento'    => '4',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Minibar 26L 2ªun.',
            'dt_compra_equipamento'     => '2018-09-15',
            'nr_valor_equipamento'      => '1789',
            'fk_pk_tipo_equipamento'    => '4',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Minibar 20L 2ªun.',
            'dt_compra_equipamento'     => '2018-09-15',
            'nr_valor_equipamento'      => '1789',
            'fk_pk_tipo_equipamento'    => '4',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Televisao AOC 50"',
            'dt_compra_equipamento'     => '2018-09-28',
            'nr_valor_equipamento'      => '2600',
            'fk_pk_tipo_equipamento'    => '2',
        ]);
        $equipamento = Equipamento::create([
            'nm_equipamento'            => 'Televisao AOC 50 2ªun"',
            'dt_compra_equipamento'     => '2018-09-28',
            'nr_valor_equipamento'      => '2600',
            'fk_pk_tipo_equipamento'    => '2',
        ]);

        //EMPRESA
        $empresa = Empresa::create([
            'nm_empresa'            => 'Orkan Service',
            'ds_endereco_empresa'   => 'Quinta com a Quarta 105',
            'ds_telefone_empresa'   => '30308924',
            'ds_cnpj_empresa'       => '05.648.886/0001-06',
            'ds_email_empresa'      => 'orkanservice@gmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Flateck Eletrônica',
            'ds_endereco_empresa'   => 'Asa Sul, setor de quadras 10',
            'ds_telefone_empresa'   => '656879214',
            'ds_cnpj_empresa'       => '20.954.582/0001-52',
            'ds_email_empresa'      => 'flateckcircuitos@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Total Eletrônica',
            'ds_endereco_empresa'   => 'Taguatinga Sul',
            'ds_telefone_empresa'   => '56471646',
            'ds_cnpj_empresa'       => '56.158.253/0001-42',
            'ds_email_empresa'      => 'totalreparos@gmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Solvetronic',
            'ds_endereco_empresa'   => 'Samambaia quadra 2',
            'ds_telefone_empresa'   => '56581262',
            'ds_cnpj_empresa'       => '22.081.707/0001-02',
            'ds_email_empresa'      => 'solvereparos@tec.web',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'High End - reparos',
            'ds_endereco_empresa'   => 'SAU/SUL Quadra 2, Bloco A',
            'ds_telefone_empresa'   => '13567896',
            'ds_cnpj_empresa'       => '22.081.707/0001-02',
            'ds_email_empresa'      => 'high@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Zap Serviços',
            'ds_endereco_empresa'   => 'Rio de janeiro',
            'ds_telefone_empresa'   => '30306481',
            'ds_cnpj_empresa'       => '35.262.456/0001-04',
            'ds_email_empresa'      => 'high@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Climart Ar Condicionado',
            'ds_endereco_empresa'   => 'Av. das Palmeiras',
            'ds_telefone_empresa'   => '13154657',
            'ds_cnpj_empresa'       => '83.686.351/0001-25',
            'ds_email_empresa'      => 'teste@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Rd Gois Serviços E Manutenções',
            'ds_endereco_empresa'   => 'Av. das Araucarias',
            'ds_telefone_empresa'   => '13154657',
            'ds_cnpj_empresa'       => '94.925.904/0001-71',
            'ds_email_empresa'      => 'teste@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Luftec Comércio E Serviços',
            'ds_endereco_empresa'   => 'SOF Sul',
            'ds_telefone_empresa'   => '2165441',
            'ds_cnpj_empresa'       => '60.787.118/0001-33',
            'ds_email_empresa'      => 'teste@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Fc Manutenções E Reformas',
            'ds_endereco_empresa'   => 'Rio das Ostras',
            'ds_telefone_empresa'   => '5056510',
            'ds_cnpj_empresa'       => '72.160.514/0001-15',
            'ds_email_empresa'      => 'teste@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Kya Reformas E Construçoes Ltda',
            'ds_endereco_empresa'   => 'Nava iguaçu',
            'ds_telefone_empresa'   => '5056510',
            'ds_cnpj_empresa'       => '04.440.186/0001-50',
            'ds_email_empresa'      => 'teste@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Exatta Servicos',
            'ds_endereco_empresa'   => 'Caratinga MG',
            'ds_telefone_empresa'   => '50582110',
            'ds_cnpj_empresa'       => '11.890.105/0001-80',
            'ds_email_empresa'      => 'teste@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Rmb Serviços Eletricos',
            'ds_endereco_empresa'   => 'Jundiaí SP',
            'ds_telefone_empresa'   => '96582110',
            'ds_cnpj_empresa'       => '44.014.583/0001-85',
            'ds_email_empresa'      => 'teste@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Rocha Elétrica',
            'ds_endereco_empresa'   => 'Mogi SP',
            'ds_telefone_empresa'   => '78182110',
            'ds_cnpj_empresa'       => '58.687.253/0001-65',
            'ds_email_empresa'      => 'teste@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Ss Sr. Solução',
            'ds_endereco_empresa'   => 'Santo André SP',
            'ds_telefone_empresa'   => '5458881',
            'ds_cnpj_empresa'       => '65.272.142/0001-53',
            'ds_email_empresa'      => 'teste@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'G&l Service E Manutenção ',
            'ds_endereco_empresa'   => 'São Bernardo SP',
            'ds_telefone_empresa'   => '40404081',
            'ds_cnpj_empresa'       => '86.874.822/0001-17',
            'ds_email_empresa'      => 'teste@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Gr1 Ar Codicionado Central',
            'ds_endereco_empresa'   => 'Zona Centro RJ',
            'ds_telefone_empresa'   => '80404501',
            'ds_cnpj_empresa'       => '52.392.057/0001-87',
            'ds_email_empresa'      => 'teste@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Ribeiro Contruçao',
            'ds_endereco_empresa'   => 'Mariápolis',
            'ds_telefone_empresa'   => '80477501',
            'ds_cnpj_empresa'       => '80.175.238/0001-97',
            'ds_email_empresa'      => 'teste@hotmail.com',
        ]);

        $manutencao = Manutencao::create([
            'ds_descricao_manutencao'  => 'Reparo preventivo',
            'dt_manutencao'            => '2018-12-09',
            'vl_valor_manutencao'      => '380',
            'fk_pk_tipo_manutencao'    => '1',
            'fk_pk_prioridade'         => '3',
            'fk_pk_situacao'           => '3',
            'fk_pk_avaliacao'          => '1',
            'fk_pk_empresa'            => '1',
            'fk_pk_equipamento'        => '1',
        ]);
        $manutencao = Manutencao::create([
            'ds_descricao_manutencao'  => 'Lubrificação de peças',
            'dt_manutencao'            => '2019-03-09',
            'vl_valor_manutencao'      => '380',
            'fk_pk_tipo_manutencao'    => '1',
            'fk_pk_prioridade'         => '3',
            'fk_pk_situacao'           => '3',
            'fk_pk_avaliacao'          => '1',
            'fk_pk_empresa'            => '1',
            'fk_pk_equipamento'        => '1',
        ]);
        $manutencao = Manutencao::create([
            'ds_descricao_manutencao'  => 'Verificação de gás',
            'dt_manutencao'            => '2019-06-12',
            'vl_valor_manutencao'      => '380',
            'fk_pk_tipo_manutencao'    => '1',
            'fk_pk_prioridade'         => '3',
            'fk_pk_situacao'           => '3',
            'fk_pk_avaliacao'          => '1',
            'fk_pk_empresa'            => '1',
            'fk_pk_equipamento'        => '1',
        ]);
        $manutencao = Manutencao::create([
            'ds_descricao_manutencao'  => 'Verificação de canaletas',
            'dt_manutencao'            => '2019-09-15',
            'vl_valor_manutencao'      => '380',
            'fk_pk_tipo_manutencao'    => '1',
            'fk_pk_prioridade'         => '3',
            'fk_pk_situacao'           => '3',
            'fk_pk_avaliacao'          => '1',
            'fk_pk_empresa'            => '1',
            'fk_pk_equipamento'        => '1',
        ]);
        $manutencao = Manutencao::create([
            'ds_descricao_manutencao'  => 'Checar fiação',
            'dt_manutencao'            => '2019-12-18',
            'vl_valor_manutencao'      => '380',
            'fk_pk_tipo_manutencao'    => '1',
            'fk_pk_prioridade'         => '3',
            'fk_pk_situacao'           => '3',
            'fk_pk_avaliacao'          => '1',
            'fk_pk_empresa'            => '1',
            'fk_pk_equipamento'        => '1',
        ]);
        $manutencao = Manutencao::create([
            'ds_descricao_manutencao'  => 'Trocar Exautor com problemas',
            'dt_manutencao'            => '2019-12-25',
            'vl_valor_manutencao'      => '560',
            'fk_pk_tipo_manutencao'    => '2',
            'fk_pk_prioridade'         => '3',
            'fk_pk_situacao'           => '3',
            'fk_pk_avaliacao'          => '1',
            'fk_pk_empresa'            => '1',
            'fk_pk_equipamento'        => '1',
        ]);
        $manutencao = Manutencao::create([
            'ds_descricao_manutencao'  => 'Troca do comando remoto defeituoso',
            'dt_manutencao'            => '2019-12-25',
            'vl_valor_manutencao'      => '287',
            'fk_pk_tipo_manutencao'    => '2',
            'fk_pk_prioridade'         => '3',
            'fk_pk_situacao'           => '1',
            'fk_pk_avaliacao'          => '1',
            'fk_pk_empresa'            => '1',
            'fk_pk_equipamento'        => '1',
        ]);
    }
}
