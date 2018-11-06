<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Siscom</title>
    </head>
    <body>
        <h2>Siscom - Geração de Relatórios - {{ date('d/m/y') }}</h2>
        <hr/>
        <b><label>Nome:</b> {{ $recuperandoDados->nm_equipamento }}</label><br>
        <b><label>Valor:</b> {{ $recuperandoDados->nr_valor_equipamento }}</label><br>
        <b><label>Data de compra:</b> {{ $recuperandoDados->dt_compra_equipamento }}</label><br>
        <b><label>Descrição: </b>{{ $recuperandoDados->ds_descricao_equipamento }}</label><br>
        @if($recuperandoDados->fk_pk_tipo_equipamento === 1)
            <b><label>Tipo:</b> Eletroeletrônico</label><br>
        @elseif($recuperandoDados->fk_pk_tipo_equipamento === 2)
            <b><label>Tipo:</b> Eletrônico</label><br>
        @elseif($recuperandoDados->fk_pk_tipo_equipamento === 3)
            <b><label>Tipo:</b> Elétrico</label><br>
        @elseif($recuperandoDados->fk_pk_tipo_equipamento === 4)
            <b><label>Tipo: </b>Eletrodoméstico</label><br>
        @endif
        <hr/>
        <b><label>Quantidade de Manutenções Realizadas:</b> {{ $qtdManutencao }}</label><br>
        <b><label>Valor Total:</b> {{ $valorTotalEquipamento }}</label><br>
        <b><label>Valor Total das Manutenções: </b>{{ $valorTotalManutencao }}</label><br>
        <hr/>
        <h3>Balanço de Manutenções</h3>
        @if($manutencaoConcluida != null)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th></th>
                        <th>Descrição</th>
                        <th></th>
                        <th>Valor</th>
                        <th></th>
                        <th>Data</th>
                        <th></th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    @foreach($manutencaoConcluida as $item)
                    <tr>
                        <th></th>
                        <td>{{ $item->pk_manutencao }}</td>
                        <th></th>
                        <td>{{ $item->ds_descricao_manutencao }}</td>
                        <th></th>
                        <td>{{ $item->vl_valor_manutencao }}</td>
                        <th></th>
                        <td>{{ $item->dt_manutencao }}</td>
                        <th></th>
                        <td>Concluída</td>
                        <th></th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <br><b><label>Total de Manutenções Concluídas: </b> {{ $qtdManutencaoConcluida }}</label><br><br>
        
        <hr/>
        @if($manutencaoEmAndamento != null)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th></th>
                        <th>Descrição</th>
                        <th></th>
                        <th>Valor</th>
                        <th></th>
                        <th>Data</th>
                        <th></th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                        @foreach($manutencaoEmAndamento as $item)
                        <tr>
                            <th></th>
                            <td>{{ $item->pk_manutencao }}</td>
                            <th></th>
                            <td>{{ $item->ds_descricao_manutencao }}</td>
                            <th></th>
                            <td>{{ $item->vl_valor_manutencao }}</td>
                            <th></th>
                            <td>{{ $item->dt_manutencao }}</td>
                            <th></th>
                            <td>Em Andamento</td>
                            <th></th>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        @endif
        <br><b><label>Total de Manutenções Em Andamento: </b> {{ $qtdManutencaoEmAndamento }}</label><br><br>
        
        <hr/>
        @if($manutencaoPendente != null)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>|</th>
                        <th>#</th>
                        <th>|</th>
                        <th>Descrição</th>
                        <th>|</th>
                        <th>Valor</th>
                        <th>|</th>
                        <th>Data</th>
                        <th>|</th>
                        <th>Status</th>
                        <th>|</th>
                    </tr>
                        @foreach($manutencaoPendente as $item)
                        <tr>
                            <th></th>
                            <td>{{ $item->pk_manutencao }}</td>
                            <th></th>
                            <td>{{ $item->ds_descricao_manutencao }}</td>
                            <th></th>
                            <td>{{ $item->vl_valor_manutencao }}</td>
                            <th></th>
                            <td>{{ $item->dt_manutencao }}</td>
                            <th></th>
                            <td>Pendente</td>
                            <th></th>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        @endif
        <br><b><label>Total de Manutenções Pendentes: </b> {{ $qtdManutencaoPendente }}</label><br><br>
    </body>
</html>