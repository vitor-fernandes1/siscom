<?php

use Illuminate\Database\Seeder;
use App\Models\Equipamento;
use App\Models\Prioridade;
use App\Models\Situacao;
use App\Models\TipoEquipamento;
use App\Models\TipoManutencao;
use App\Models\Empresa;

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

        //EMPRESA
        $empresa = Empresa::create([
            'nm_empresa'            => 'Orkan Service',
            'ds_endereco_empresa'   => 'Quinta com a Quarta 105',
            'ds_telefone_empresa'   => '30308924',
            'ds_email_empresa'      => 'orkanservice@gmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Flateck Eletrônica',
            'ds_endereco_empresa'   => 'Asa Sul, setor de quadras 10',
            'ds_telefone_empresa'   => '656879214',
            'ds_email_empresa'      => 'flateckcircuitos@hotmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Total Eletrônica',
            'ds_endereco_empresa'   => 'Taguatinga Sul',
            'ds_telefone_empresa'   => '56471646',
            'ds_email_empresa'      => 'totalreparos@gmail.com',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'Solvetronic',
            'ds_endereco_empresa'   => 'Samambaia quadra 2',
            'ds_telefone_empresa'   => '56581262',
            'ds_email_empresa'      => 'solvereparos@tec.web',
        ]);
        $empresa = Empresa::create([
            'nm_empresa'            => 'High End - reparos',
            'ds_endereco_empresa'   => 'SAU/SUL Quadra 2, Bloco A',
            'ds_telefone_empresa'   => '13567896',
            'ds_email_empresa'      => 'high@hotmail.com',
        ]);
        
    }
}
