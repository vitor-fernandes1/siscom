@extends('adminlte::page')

@section('title', 'Siscom')

@section('content_header')
    <h1>Baixar Manutenção</h1>
@stop

@section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<div class="box box-primary">
  <div class="box-body">
  @include('includes.alerts')
      <div class="form-group">
         <label for="example-text-input" class="col-2 col-form-label">Descrição</label>
         <div class="col-10">
            <input class="form-control" type="text" name="nm_equipamento" value="{{ $recuperandoDados->ds_descricao_manutencao }}" disabled>
         </div>
      </div>
      <div class="form-group">
         <label for="example-search-input" class="col-2 col-form-label">Valor</label>
         <div class="col-10">
            <input class="form-control" type="number" name="nr_valor_equipamento" value="{{ $recuperandoDados->vl_valor_manutencao }}" disabled>
         </div>
      </div>
      <div class="form-group">
         <label for="example-date-input" class="col-2 col-form-label">Data</label>
         <div class="col-10">
            <input class="form-control" type="date" name="dt_compra_equipamento" value="{{ $recuperandoDados->dt_manutencao }}" disabled>
         </div>
      </div>
      <div class="form-group">
         <label for="example-email-input" class="col-2 col-form-label">Situação</label>
         <div class="col-10">
          @if( $recuperandoDados->fk_pk_situacao === 1 )
            <input class="form-control" type="text" name="ds_descricao_equipamento" value="Em andamento" disabled>
          @elseif( $recuperandoDados->fk_pk_situacao === 2 )
            <input class="form-control" type="text" name="ds_descricao_equipamento" value="Pendente" disabled>
          @endif
         </div>
      </div>
    <div align="left">
      <h3>Indique uma avaliação sobre o serviço da empresa: <i>{{ $dadosEmpresa['0']->nm_empresa }} CNPJ: {{ $dadosEmpresa['0']->ds_cnpj_empresa }} </i></h3>
      <br>
    </div>
    <div class="col-lg-4 col-xs-7" align="center">
      <a href="{{ $recuperandoDados->pk_manutencao }}/1"><i class="fas fa-smile-beam fa-5x text-green" ></i> <div><b>Ótimo</div></a>
    </div>
    <div class="col-lg-4 col-xs-7" align="center">
      <a href="{{ $recuperandoDados->pk_manutencao }}/2"><i class="fas fa-meh fa-5x text-primary" ></i> <div><b>Médio</div></a>
    </div>
    <div class="col-lg-4 col-xs-7" align="center">
      <a href="{{ $recuperandoDados->pk_manutencao }}/3"><i class="fas fa-angry fa-5x text-red"></i> <div><b>Ruim</div></a>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript">

@stop