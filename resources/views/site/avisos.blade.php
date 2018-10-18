@extends('adminlte::page')
@section('title', 'Siscom')
@section('content_header')
<h1>Avisos</h1>
@stop
@section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<div class="box box-primary">
<!-- /.box-header -->
<div class="box-body">
<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
<div class="row">
   <div class="col-sm-6"></div>
   <div class="col-sm-6"></div>
</div>
<div class="row">
   <div class="col-sm-12">
      <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
         <thead>
            <tr role="row">
               <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  aria-sort="ascending">Mensagem</th>
               <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >Prioridade</th>
            </tr>
         </thead>
         <tbody>
            @if($equipamentoDoisAnosSemManutencao != null) 
            @foreach($equipamentoDoisAnosSemManutencao as $item)
            <tr role="row" class="odd">
               <td class="sorting_1"><b>O equipamento COD:{{ $item['pk_equipamento'] }} - {{ $item['nm_equipamento'] }}({{ $item['dt_compra_equipamento'] }}) não recebeu manutenções nos ultimos 2 anos, fique atento!</b></td>
               <td><i class="fas fa-circle text-red"></i><b>  - Alto</b></td>
            </tr>
            @endforeach
            @endif
            @if($equipamentoUmAnoSemManutencao != null)
            @foreach($equipamentoUmAnoSemManutencao as $item)
            <tr role="row" class="odd">
               <td class="sorting_1"><b>O equipamento COD:{{ $item['pk_equipamento'] }} - {{ $item['nm_equipamento'] }}({{ $item['dt_compra_equipamento'] }}) não recebeu manutenções nos ultimos 1 ano, fique atento!</b></td>
               <td><i class="fas fa-circle text-yellow"></i><b>  - Médio</b></td>
            </tr>
            @endforeach
            @endif
            @if($equipamentoSeisMesesSemManutencao != null)
            @foreach($equipamentoSeisMesesSemManutencao as $item)
            <tr role="row" class="odd">
               <td class="sorting_1"><b>O equipamento COD:{{ $item['pk_equipamento'] }} - {{ $item['nm_equipamento'] }}({{ $item['dt_compra_equipamento'] }}) não recebeu manutenções nos ultimos 6 meses, fique atento!</b></td>
               <td><i class="fas fa-circle text-green"></i><b>  - Baixo</b></td>
            </tr>
            @endforeach
            @endif
         </tbody>
      </table>
   </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script>
   $(function () {
     $('#example2').DataTable({
       'paging'      : true,
       'lengthChange': false,
       'searching'   : false,
       'ordering'    : true,
       'info'        : true,
       'autoWidth'   : false,
     })
   })
</script>
@stop