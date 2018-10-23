@extends('adminlte::page')
@section('title', 'Siscom')
@section('content_header')
<h1>Indicar</h1>
@stop
@section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<div class="box box-primary">
<div class="box-body">
<div class="col-md-12">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Por tipo de manutenção</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <b>Preventiva</b> - <cite>Apresentar melhor empresa prestadora de serviços preventivos<cite>
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="box-body">
                    @if($dadosEmpresaMelhorAvaliadaPreventiva != null)
                    <div class="col-sm-12 col-md-12">
                    <div class="box box-solid">
                        <div class="box-body">
                          <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                            <b>{{ $dadosEmpresaMelhorAvaliadaPreventiva['nm_empresa'] }}</b>
                          </h4>
                          <div class="media">
                              <div class="media-left">
                                <i class="fas fa-check fa-7x text-green"></i>
                              </div>
                              <div class="media-body">
                                <div class="clearfix">
                                    <h4 style="margin-top: 0">Contato:</h4>
                                    <p>
                                      <label>Nome: {{ $dadosEmpresaMelhorAvaliadaPreventiva['nm_empresa'] }}</label> <br>
                                      <label>Endereço: {{ $dadosEmpresaMelhorAvaliadaPreventiva['ds_endereco_empresa'] }}</label><br>
                                      <label>Email: {{ $dadosEmpresaMelhorAvaliadaPreventiva['ds_email_empresa'] }}</label><br>
                                      <label>Telefone: {{ $dadosEmpresaMelhorAvaliadaPreventiva['ds_telefone_empresa'] }}</label><br></p>
                                    <p style="margin-bottom: 0">
                                    <i class="fas fa-wrench text-blue"></i> Já efetuou <b>{{ $dadosEmpresaMelhorAvaliadaPreventiva['qtdManutencoes'] }}</b> manutenções<br>
                                    @if( ($dadosEmpresaMelhorAvaliadaPreventiva['superiorMedia']) == false)
                                      <i class="fas fa-star-half-alt text-yellow"></i> A empresa possui notas <b>Médias</b><br>
                                      <i class="fas fa-lightbulb text-green"></i> Pode ser interessante a contratação de uma nova empresa para melhorar ainda mais o rendimento.
                                    @elseif( ($dadosEmpresaMelhorAvaliadaPreventiva['superiorMedia']) == true)
                                      <i class="fas fa-star-half-alt text-yellow"></i> A empresa possui notas <b>Ótimas</b><br>
                                      <i class="fas fa-lightbulb text-green"></i> Contratar está empresa é sempre uma boa ideia!
                                    @endif
                                    </p>
                                </div>
                              </div>
                          </div>
                        </div>
                    </div>
                  </div>
                  @endif
                    </div>
                  </div>
                </div>
                <div class="panel box box-danger">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        Collapsible Group Danger
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="box-body">
                      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                      wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                      eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                      assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                      nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                      farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                      labore sustainable VHS.
                    </div>
                  </div>
                </div>
                <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        Collapsible Group Success
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse">
                    <div class="box-body">
                      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                      wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                      eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                      assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                      nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                      farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                      labore sustainable VHS.
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

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
   $(document).ready( function () { $('#table_id').DataTable(); } );
</script>
<script>
   $(document).ready( function () {
     $('#table_id').DataTable();
   } );  
</script>
@stop