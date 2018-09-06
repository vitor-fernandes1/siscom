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

            <form method="POST" action="{{ route('equipamento.store') }}">
                {!! csrf_field() !!}
               <!-- <div class="form-group">
                    <label for="example-text-input" class="col-2 col-form-label">Nome</label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="nm_equipamento" value="{{ old('nm_equipamento') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="example-search-input" class="col-2 col-form-label">Valor</label>
                    <div class="col-10">
                        <input class="form-control" type="number" name="ds_valor_equipamento" value="{{ old('ds_valor_equipamento') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="example-date-input" class="col-2 col-form-label">Data de compra</label>
                    <div class="col-10">
                        <input class="form-control" type="date" name="dt_compra_equipamento" value="{{ old('dt_compra_equipamento') }}" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="example-email-input" class="col-2 col-form-label">Descrição</label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="ds_descricao_equipamento" value="{{ old('ds_descricao_equipamento') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleSelect1">Tipo</label>
                    <select class="form-control" name="fk_pk_tipo_equipamento" id="fk_pk_tipo_equipamento">
                        <option>1 - Eletroeletrônico</option>
                        <option>2 - Eletrônico</option>
                        <option>3 - Elétrico</option>
                        <option>4 - Eletrodoméstico</option>
                    </select>
                </div>-->
                <div class="form-group">

                    <div class="row">
                        <div class="col-xs-4">
                            <label for="example-text-input" class="col-2 col-form-label">Nome</label>
                            <input class="form-control" type="text" name="nm_equipamento" value="{{ old('nm_equipamento') }}">
                        </div>

                        <div class="col-xs-4">
                            <label for="example-text-input" class="col-2 col-form-label">Valor</label>
                            <input class="form-control" type="number" name="nr_valor_equipamento" value="{{ old('nr_valor_equipamento') }}">  
                        </div>

                        <div class="col-xs-4">
                            <label for="example-text-input" class="col-2 col-form-label">Data da compra</label>
                            <input class="form-control" type="date" name="dt_compra_equipamento" value="{{ old('dt_compra_equipamento') }}" >  
                        </div>

                        <div class="col-xs-4">
                            <label for="example-text-input" class="col-2 col-form-label">Descrição</label>
                            <textarea class="form-control" rows="2" name="ds_descricao_equipamento">{{ old('ds_descricao_equipamento') }}</textarea>
                        </div>

                        <div class="col-xs-4">
                            <label for="exampleSelect1">Tipo</label>
                            <select class="form-control" name="fk_pk_tipo_equipamento" id="fk_pk_tipo_equipamento">
                                    <option>1 - Eletroeletrônico</option>
                                    <option>2 - Eletrônico</option>
                                    <option>3 - Elétrico</option>
                                    <option>4 - Eletrodoméstico</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#exampleModal"> <i class="fas fa-plus"></i>  Adicionar</button>        
                </div>

            </form>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-body">

            <table class="table">

                <thead class="thead-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Data de compra</th>
                    <th scope="col">Tipo</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($recuperandoDados as $item)
                            <tr>
                            <th scope="row">{{ $item->pk_equipamento }}</th>
                            <td>{{ $item->nm_equipamento }}</td>
                            <td>{{ $item->nr_valor_equipamento }}</td>
                            <td>{{ $item->dt_compra_equipamento }}</td>
                            <td>{{ $item->fk_pk_tipo_equipamento }}</td>
                            </tr>
                    @endforeach
                </tbody>

            </table>
            {!! $recuperandoDados->links() !!}
        </div>
    </div>
@stop