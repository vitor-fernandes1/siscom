<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Siscom</title>
    </head>
    <body>
        <h2>Siscom - Geração de Relatórios</h2>
        <hr/>
        <b><label>Nome:</b> {{ $recuperandoDados->nm_equipamento }}</label><br>
        <b><label>Valor:</b> {{ $recuperandoDados->nr_valor_equipamento }}</label><br>
        <b><label>Data de compra:</b> {{ $recuperandoDados->dt_compra_equipamento }}</label><br>
        <b><label>Descrição: </b>{{ $recuperandoDados->ds_descricao_equipamento }}</label><br>
        @if($recuperandoDados->fk_pk_tipo_equipamento === 1)
            <b><label>Descrição:</b> Eletroeletrônico</label><br>
        @elseif($recuperandoDados->fk_pk_tipo_equipamento === 2)
            <b><label>Descrição:</b> Eletrônico</label><br>
        @elseif($recuperandoDados->fk_pk_tipo_equipamento === 3)
            <b><label>Descrição:</b> Elétrico</label><br>
        @elseif($recuperandoDados->fk_pk_tipo_equipamento === 4)
            <b><label>Descrição: </b>Eletrodoméstico</label><br>
        @endif
        <hr/>
        <b><label>Quantidade de Manutenções Realizadas:</b> {{ $qtdManutencao }}</label><br>
        <b><label>Valor Total:</b> {{ $valorTotalEquipamento }}</label><br>
        <b><label>Valor Total das Manutenções: </b>{{ $valorTotalManutencao }}</label><br>
        <hr/>
        <h3>Balanço de Manutenções</h3>
        <label></label><br>
    </body>
</html>