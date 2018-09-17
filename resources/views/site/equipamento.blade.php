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
                                    <option value="1">Eletroeletrônico</option>
                                    <option value="2">Eletrônico</option>
                                    <option value="3">Elétrico</option>
                                    <option value="4">Eletrodoméstico</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success"> <i class="fas fa-plus"></i>  Adicionar</button>        
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
                    <th scope="col">Ações</th>
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
                            <td>
                            <!-- <a type="button" class="btn btn-default" href=" {{ route('equipamento.update', $item->pk_equipamento) }}" data-toggle="modal" data-target="#modal-default">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a type="button" class="btn btn-default" href=" {{ route('equipamento.delete', $item->pk_equipamento) }} ">
                                <i class="fas fa-trash-alt"></i>
                            </a> -->

                            
                            <!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModal" data-nome="{{ $item->nm_equipamento }}" data-valor="{{ $item->nr_valor_equipamento }}" data-dataCompra="{{ $item->dt_compra_equipamento }}" data-pk="{{ $item->pk_equipamento }}" data-descricao="{{ $item->ds_descricao_equipamento }}"><i class="fas fa-edit"></i> Editar</button>
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat"><i class="fas fa-trash-alt"></i> Deletar</button>
                            -->
                            <a href="/equipamento/{{ $item->pk_equipamento }}"><i class="fas fa-edit"></i></a>
                            <button type="button" class="btn btn-default click-produto"  id="{{ $item->pk_equipamento }}"data-toggle="modal" data-target="#exampleModal"><i class="fas fa-edit"></i> Editar</button>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-nome="{{ $item->nm_equipamento }}">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel">Editar</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">ID</label>
                                                <input type="text" class="form-control" name="pk_equipamento" id="pk" value=" {{ $item->pk_equipamento }} ">
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Nome</label>
                                                    <input type="text" class="form-control" name="nm_equipamento" id="nome">
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Valor</label>
                                                    <input type="number" class="form-control" name="nr_valor_equipamento" id="valor">
                                                </div>
                                                <div class="form-group">
                                                    <label for="message-text" class="control-label">Descrição</label>
                                                    <textarea class="form-control" name="ds_descricao_equipamento" id="descricao"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label  for="recipient-name" class="col-form-label">Data</label>
                                                    <input class="form-control" type="date" name="dt_compra_equipamento" id="dataCompra">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Send message</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
                            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
                            <script>
                                $(document).ready(function (){
                                    $(".click-produto").click(function() {
                                        var id = $(this).attr("id");
                                        $.get('/equipamento/1', function(resultado){
                                            $("#mensagem").html(resultado);
                                        })
                                    console.log(resultado);    
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                $('#exampleModal').on('show.bs.modal', function (event) {
                                    
                                var button = $(event.relatedTarget) // Button that triggered the modal
                                var pk = button.data('pk')
                                var nome = button.data('nome')
                                var valor = button.data('valor') // Extract info from data-* attributes
                                var descricao = button.data('descricao')
                                var dataCompra = button.data('dataCompra') 
                                
                                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                                var modal = $(this)

                                console.log(dataCompra);
                                // modal.find('.modal-title').text('New message to ' + recipient)
                                modal.find('#pk').val(pk)
                                modal.find('#nome').val(nome)
                                modal.find('#valor').val(valor)
                                modal.find('#descricao').val(descricao)
                                modal.find('#dataCompra').val(dataCompra)
                                
                                //dd($modal);
                                })

                            </script>
                            <!--<div id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="panel-body">
                                                <form id="modalExemplo" method="post" action="">
                                                    <input type="text" name="campo" id="campo">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function setaDadosModal(item) {
                                    document.getElementById('campo').value = $item->pk_equipamento;
                                }
                            </script> -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            {!! $recuperandoDados->links() !!}
        </div>
    </div>
@stop