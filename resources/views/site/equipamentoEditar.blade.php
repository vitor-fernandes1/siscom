@extends('adminlte::page')

@section('title', 'Siscom')

@section('content_header')
    <h1>Equipamento</h1>
@stop

@section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <div class="box box-primary">
        <div class="box-body">
        @include('includes.alerts')
            <form method="POST" action="{{ route( 'equipamento.update', ['equipamento' => $recuperandoDados->pk_equipamento] )}}">
                <input type="hidden" name="_method" value="PUT">
                {!! csrf_field() !!}   
                <div class="form-group">
                    <label for="example-text-input" class="col-2 col-form-label">Nome</label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="nm_equipamento" value="{{ $recuperandoDados->nm_equipamento }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="example-search-input" class="col-2 col-form-label">Valor</label>
                    <div class="col-10">
                        <input class="form-control" type="number" name="nr_valor_equipamento" value="{{ $recuperandoDados->nr_valor_equipamento }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="example-date-input" class="col-2 col-form-label">Data de compra</label>
                    <div class="col-10">
                         <input class="form-control" type="date" name="dt_compra_equipamento" value="{{ $recuperandoDados->dt_compra_equipamento }}" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="example-email-input" class="col-2 col-form-label">Descrição</label>
                    <div class="col-10">
                        <textarea class="form-control" rows="2" name="ds_descricao_equipamento">{{ $recuperandoDados->ds_descricao_equipamento }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleSelect1">Tipo</label>
                        <select class="form-control" name="fk_pk_tipo_equipamento" id="fk_pk_tipo_equipamento">
                            @if($recuperandoDados->fk_pk_tipo_equipamento === 1)
                                <option value="1">Eletroeletrônico</option>
                                <option value="2">Eletrônico</option>
                                <option value="3">Elétrico</option>
                                <option value="4">Eletrodoméstico</option>
                            @elseif($recuperandoDados->fk_pk_tipo_equipamento === 2)
                                <option value="2">Eletrônico</option>
                                <option value="1">Eletroeletrônico</option>
                                <option value="3">Elétrico</option>
                                <option value="4">Eletrodoméstico</option>
                            @elseif($recuperandoDados->fk_pk_tipo_equipamento === 3)
                                <option value="3">Elétrico</option>
                                <option value="2">Eletrônico</option>
                                <option value="1">Eletroeletrônico</option>
                                <option value="4">Eletrodoméstico</option>
                            @elseif($recuperandoDados->fk_pk_tipo_equipamento === 4)
                                <option value="4">Eletrodoméstico</option>
                                <option value="3">Elétrico</option>
                                <option value="2">Eletrônico</option>
                                <option value="1">Eletroeletrônico</option>
                            @endif
                        </select>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success" > <i class="fas fa-edit"></i>  Editar</button>        
                    </div>
                </div>
            <form>
        </div>
    </div>
@stop