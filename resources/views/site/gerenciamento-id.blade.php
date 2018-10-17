@extends('adminlte::page')
@section('title', 'Siscom')
@section('content_header')
<h1>Gerenciamento - <cite>Informações</cite></h1>
@stop
@section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<div class="box box-primary">
   <div class="box-body">
      @include('includes.alerts')
      <div class="form-group">
         <label for="example-text-input" class="col-2 col-form-label">Nome</label>
         <div class="col-10">
            <input class="form-control" type="text" name="nm_equipamento" value="{{ $recuperandoDados->nm_equipamento }}" disabled>
         </div>
      </div>
      <div class="form-group">
         <label for="example-search-input" class="col-2 col-form-label">Valor</label>
         <div class="col-10">
            <input class="form-control" type="number" name="nr_valor_equipamento" value="{{ $recuperandoDados->nr_valor_equipamento }}" disabled>
         </div>
      </div>
      <div class="form-group">
         <label for="example-date-input" class="col-2 col-form-label">Data de compra</label>
         <div class="col-10">
            <input class="form-control" type="date" name="dt_compra_equipamento" value="{{ $recuperandoDados->dt_compra_equipamento }}" disabled>
         </div>
      </div>
      <div class="form-group">
         <label for="example-email-input" class="col-2 col-form-label">Descrição</label>
         <div class="col-10">
            <textarea class="form-control" rows="2" name="ds_descricao_equipamento" disabled>{{ $recuperandoDados->ds_descricao_equipamento }}</textarea>
         </div>
      </div>
      <div class="form-group">
         <label for="exampleSelect1">Tipo</label>
         <select class="form-control" name="fk_pk_tipo_equipamento" id="fk_pk_tipo_equipamento" disabled>
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
      </div>
   </div>
</div>

<div class="box box-primary">
   <div class="box-body">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Dias de uso</span>
                    <span class="info-box-number">{{ $diasUsoEquipamento }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fas fa-calendar-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Meses de uso</span>
                    <span class="info-box-number">{{ $mesesUsoEquipamento }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fas fa-birthday-cake"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Anos de uso</span>
                    <span class="info-box-number">{{ $anosUsoEquipamento }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="box box-solid">
                <h3>Vida útil estimada do equipamento: {{ $porcentagemBarra }}%</h3>
                @if($porcentagemBarra < 40)
                <div class="progress progress active">
                    <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: {{ $porcentagemBarra }}%"></div>
                </div>
                @elseif($porcentagemBarra < 70)
                <div class="progress progress active">
                    <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: {{ $porcentagemBarra }}%"></div>
                </div>
                @else
                <div class="progress progress active">
                    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: {{ $porcentagemBarra }}%"></div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
@stop