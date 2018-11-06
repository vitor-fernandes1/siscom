@extends('adminlte::page')
@section('title', 'Siscom')
@section('content_header')
<h1>Estatística - <cite>Informações</cite></h1>
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
         <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fas fa-hand-holding-usd"></i></span>
            <div class="info-box-content">
               <span class="info-box-text">Valor Total</span>
               <span class="info-box-number">{{ $valorTotalEquipamento }}</span>
               <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
               </div>
               <span class="progress-description">
               <cite>Vlr. Equipamento + manutenções</cite>
               </span>
            </div>
            <!-- /.info-box-content -->
         </div>
         <!-- /.info-box -->
      </div>
      <div class="col-md-4 col-sm-6 col-xs-12">
         <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
            <div class="info-box-content">
               <span class="info-box-text">Valor das manutenções</span>
               <span class="info-box-number">{{ $valorTotalManutencao }}</span>
               <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
               </div>
               <span class="progress-description">
               <cite>Vlr. total das manutenções</cite>
               </span>
            </div>
            <!-- /.info-box-content -->
         </div>
         <!-- /.info-box -->
      </div>
      <div class="col-md-4 col-sm-6 col-xs-12">
         <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fas fa-wrench"></i></span>
            <div class="info-box-content">
               <span class="info-box-text">Qtde. de manutenções</span>
               <span class="info-box-number">{{ $qtdManutencao }}</span>
               <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
               </div>
               <span class="progress-description">
               <cite>Total de manutenções</cite>
               </span>
            </div>
            <!-- /.info-box-content -->
         </div>
         <!-- /.info-box -->
      </div>
      <div class="col-md-12">
         <div class="box box-solid">
            <div class="box-header with-border">
               <h3 class="box-title"><i class="fas fa-th"></i> Manutenções por situação</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <div class="box-group" id="accordion">
                  <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                  <div class="panel box box-success">
                     <div class="box-header with-border">
                        <h4 class="box-title">
                           <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
                           Concluídas
                           </a>
                        </h4>
                     </div>
                     <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                           <div class="box">
                              <div class="box-body">
                                 <table class="table table-bordered">
                                    <tbody>
                                       <tr>
                                          <th style="width: 10px">#</th>
                                          <th>Descrição</th>
                                          <th>Valor</th>
                                          <th>Data</th>
                                          <th>Progresso</th>
                                          <th style="width: 40px">%</th>
                                       </tr>
                                       
                                       @if($manutencaoConcluida != null)
                                       @foreach($manutencaoConcluida as $item)
                                       <tr>
                                          <td>{{ $item->pk_manutencao }}</td>
                                          <td>{{ $item->ds_descricao_manutencao }}</td>
                                          <td>{{ $item->vl_valor_manutencao }}</td>
                                          <td>{{ $item->dt_manutencao }}</td>
                                          <td>
                                             <div class="progress progress-xs">
                                                <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                                             </div>
                                          </td>
                                          <td><span class="badge bg-green">100%</span></td>
                                       </tr>
                                       @endforeach
                                       @endif
                                    </tbody>
                                 </table>
                              </div>
                              <!-- /.box-body -->
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="panel box box-warning">
                     <div class="box-header with-border">
                        <h4 class="box-title">
                           <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
                           Em andamento
                           </a>
                        </h4>
                     </div>
                     <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">
                        <div class="box-body">
                        <div class="box">
                              <div class="box-body">
                                 <table class="table table-bordered">
                                    <tbody>
                                       <tr>
                                          <th style="width: 10px">#</th>
                                          <th>Descrição</th>
                                          <th>Valor</th>
                                          <th>Data</th>
                                          <th>Progresso</th>
                                          <th style="width: 40px">%</th>
                                       </tr>
                                       @if($manutencaoEmAndamento != null)
                                       @foreach($manutencaoEmAndamento as $item)
                                       <tr>
                                          <td>{{ $item->pk_manutencao }}</td>
                                          <td>{{ $item->ds_descricao_manutencao }}</td>
                                          <td>{{ $item->vl_valor_manutencao }}</td>
                                          <td>{{ $item->dt_manutencao }}</td>
                                          <td>
                                             <div class="progress progress-xs">
                                                <div class="progress-bar progress-bar-warning" style="width: 75%"></div>
                                             </div>
                                          </td>
                                          <td><span class="badge bg-yellow">75%</span></td>
                                       </tr>
                                       @endforeach
                                       @endif
                                    </tbody>
                                 </table>
                              </div>
                              <!-- /.box-body -->
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="panel box box-danger">
                     <div class="box-header with-border">
                        <h4 class="box-title">
                           <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed" aria-expanded="false">
                           Pendentes
                           </a>
                        </h4>
                     </div>
                     <div id="collapseThree" class="panel-collapse collapse" aria-expanded="false">
                        <div class="box-body">
                        <div class="box">
                              <div class="box-body">
                                 <table class="table table-bordered">
                                    <tbody>
                                       <tr>
                                          <th style="width: 10px">#</th>
                                          <th>Descrição</th>
                                          <th>Valor</th>
                                          <th>Data</th>
                                          <th>Progresso</th>
                                          <th style="width: 40px">%</th>
                                       </tr>
                                       @if($manutencaoPendente != null)
                                       @foreach($manutencaoPendente as $item)
                                       <tr>
                                          <td>{{ $item->pk_manutencao }}</td>
                                          <td>{{ $item->ds_descricao_manutencao }}</td>
                                          <td>{{ $item->vl_valor_manutencao }}</td>
                                          <td>{{ $item->dt_manutencao }}</td>
                                          <td>
                                             <div class="progress progress-xs">
                                                <div class="progress-bar progress-bar-warning" style="width: 75%"></div>
                                             </div>
                                          </td>
                                          <td><span class="badge bg-yellow">75%</span></td>
                                       </tr>
                                       @endforeach
                                       @endif
                                    </tbody>
                                 </table>
                              </div>
                              <!-- /.box-body -->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /.box-body -->
         </div>
         <!-- /.box -->
      </div>

<div class="col-md-12">
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li class="active"><a href="#tab_1-1" data-toggle="tab">12 Meses</a></li>
              <li><a href="#tab_2-2" data-toggle="tab">6 Meses</a></li>
              <li><a href="#tab_3-2" data-toggle="tab">3 Meses</a></li>
              <li class="pull-left header"><i class="fas fa-calendar-alt"></i> Manutençoes por periodo</li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1-1">
                <b>Ultimos 12 meses</b>

                        <div class="box">
                              <div class="box-body">
                                 <table class="table table-bordered">
                                    <tbody>
                                       <tr>
                                          <th style="width: 10px">#</th>
                                          <th>Descrição</th>
                                          <th>Valor</th>
                                          <th>Data</th>
                                          <th>Progresso</th>
                                          <th style="width: 40px">%</th>
                                       </tr>
                                       @if($dadosUltimoAno != null)
                                       @foreach($dadosUltimoAno as $item)
                                       <tr>
                                          <td>{{ $item->pk_manutencao }}</td>
                                          <td>{{ $item->ds_descricao_manutencao }}</td>
                                          <td>{{ $item->vl_valor_manutencao }}</td>
                                          <td>{{ $item->dt_manutencao }}</td>
                                          <td>
                                          @if($item->fk_pk_situacao == 3)
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-green">100%</span></td>
                    </tr>
                    @elseif($item->fk_pk_situacao == 2)
                    <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: 50%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-red">50%</span></td>
                    </tr>
                    @else
                    <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-warning" style="width: 75%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-yellow">75%</span></td>
                    </tr>
                    @endif
                                       @endforeach
                                       @endif
                                    </tbody>
                                 </table>
                              </div>
                              <!-- /.box-body -->
                           </div>
                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2-2">
              <b>Ultimos 6 meses</b>

<div class="box">
      <div class="box-body">
         <table class="table table-bordered">
            <tbody>
               <tr>
                  <th style="width: 10px">#</th>
                  <th>Descrição</th>
                  <th>Valor</th>
                  <th>Data</th>
                  <th>Progresso</th>
                  <th style="width: 40px">%</th>
               </tr>
               @if($dadosUltimosSeisMeses != null)
               @foreach($dadosUltimosSeisMeses as $item)
               <tr>
                  <td>{{ $item->pk_manutencao }}</td>
                  <td>{{ $item->ds_descricao_manutencao }}</td>
                  <td>{{ $item->vl_valor_manutencao }}</td>
                  <td>{{ $item->dt_manutencao }}</td>
                  <td>
                  @if($item->fk_pk_situacao == 3)
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-green">100%</span></td>
                    </tr>
                    @elseif($item->fk_pk_situacao == 2)
                    <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: 50%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-red">50%</span></td>
                    </tr>
                    @else
                    <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-warning" style="width: 75%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-yellow">75%</span></td>
                    </tr>
                    @endif
               @endforeach
               @endif
            </tbody>
         </table>
      </div>
      <!-- /.box-body -->
   </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3-2">
              <b>Ultimos 3 meses</b>

<div class="box">
      <div class="box-body">
         <table class="table table-bordered">
            <tbody>
               <tr>
                  <th style="width: 10px">#</th>
                  <th>Descrição</th>
                  <th>Valor</th>
                  <th>Data</th>
                  <th>Progresso</th>
                  <th style="width: 40px">%</th>
               </tr>
               @if($dadosUltimosTresMeses != null)
               @foreach($dadosUltimosTresMeses as $item)
               <tr>
                  <td>{{ $item->pk_manutencao }}</td>
                  <td>{{ $item->ds_descricao_manutencao }}</td>
                  <td>{{ $item->vl_valor_manutencao }}</td>
                  <td>{{ $item->dt_manutencao }}</td>
                  <td>
                    @if($item->fk_pk_situacao == 3)
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-green">100%</span></td>
                    </tr>
                    @elseif($item->fk_pk_situacao == 2)
                    <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: 50%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-red">50%</span></td>
                    </tr>
                    @else
                    <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-warning" style="width: 75%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-yellow">75%</span></td>
                    </tr>
                    @endif
               @endforeach
               @endif
            </tbody>
         </table>
      </div>
      <!-- /.box-body -->
   </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
    
        <div align="right">
            <a href="relatorio/{{ $recuperandoDados->pk_equipamento }}"><button class="btn btn-lg"><i class="fas fa-print text-primary"></i> Imprimir</button></a>
        </div>

   </div>
</div>
@stop