@extends('adminlte::page')

@section('title', 'Siscom')

@section('content_header')
    <h1>Manutencao</h1>
@stop

@section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <!--
    <div class="box box-primary">
        <div class="box-body">

        @include('includes.alerts')

            <form method="POST" action="{{ route('manutencao.store') }}">
                {!! csrf_field() !!}
                <div class="form-group">

                    <div class="row">
                        <div class="col-xs-4">
                            <label for="example-text-input" class="col-2 col-form-label">Descrição</label>
                            <input class="form-control" type="text" name="ds_descricao_manutencao" id="nome" value="{{ old('ds_descricao_manutencao') }}">
                        </div>

                        <div class="col-xs-4">
                            <label for="example-text-input" class="col-2 col-form-label">Data</label>
                            <input class="form-control" type="date" name="dt_manutencao" value="{{ old('dt_manutencao') }}">  
                        </div>

                        <div class="col-xs-4">
                            <label for="example-text-input" class="col-2 col-form-label">Valor</label>
                            <input class="form-control" type="number" name="vl_valor_manutencao" value="{{ old('vl_valor_manutencao') }}" >  
                        </div>

                        <div class="col-xs-4">
                            <label for="example-text-input" class="col-2 col-form-label">Email</label>
                            <input class="form-control" type="text" name="ds_email_empresa" value="{{ old('ds_email_empresa') }}" >  
                        </div>

                        <div class="col-xs-4">
                            <label for="example-text-input" class="col-2 col-form-label">CNPJ</label>
                            <input class="form-control" type="text" name="ds_cnpj_empresa" value="{{ old('ds_cnpj_empresa') }}" >  
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
    -->
    <div class="box box-primary">
        <div class="box-body">

            <table class="table">

                <thead class="thead-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Data</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($recuperandoDados as $item)
                        <tr>
                            <th scope="row">{{ $item->pk_manutencao }}</th>
                            <td>{{ $item->ds_descricao_manutencao }}</td>
                            <td>{{ $item->dt_manutencao }}</td>
                            <td>{{ $item->vl_valor_manutencao }}</td>
                            <td>
                            
                            <a><button type="button" class="btn btn-primary"><i class="fas fa-edit"></i> Editar</button></a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" data-pk="{{ $item->pk_manutencao }}"><i class="fas fa-edit"></i> Deletar</button>
                            

                            <div class="modal modal-danger fade in" id="modal-danger" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title" id="exampleModalLabel">Confirmação de exclusão</h4>
                                        </div>
                                        <form action=" {{ route( 'manutencao.delete' ) }} " method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            {{method_field('delete')}}
                                            {!! csrf_field() !!}   
                                            <input type="hidden" name="pk_manutencao" id="pk">
                                        <div class="modal-body">
                                            <label>Tem certeza que deseja excluir o equipamento ?</label>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-outline">Deletar</button>
                                        </div>
                                        </form>
                                    </div>
                                        <!-- /.modal-content -->
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
                                $('#modal-danger').on('show.bs.modal', function (event) {
                                    
                                var button = $(event.relatedTarget) // Button that triggered the modal
                                var pk = button.data('pk')
                                
                                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                                var modal = $(this)
                                
                                modal.find('#pk').val(pk)
                                })

                            </script>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
@stop