@extends('adminlte::page') 
@section('title', 'Siscom') 
@section('content_header')
<h1>Indicar</h1> 
@stop @section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<div class="box box-primary">
    <div class="box-body">
        <!-- INICIO COLAPSE -->
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                <i class="fas fa-angle-right"></i></i><h3 class="box-title"> Apresentar melhor empresa prestadora por <b>tipo de manutenção</b>:</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-group" id="accordion">
                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                        
                        <!-- INICIO DOS DADOS DA COLAPSE -->
                        <div class="panel box box-success">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" >
                                    <b>Preventiva</b>
                                  </a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse" >
                                <div class="box-body">
                                    @if($dadosEmpresaMelhorAvaliadaPreventiva['indicar'] == true)
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
                                                                <label>Nome: {{ $dadosEmpresaMelhorAvaliadaPreventiva['nm_empresa'] }}</label>
                                                                <br>
                                                                <label>Endereço: {{ $dadosEmpresaMelhorAvaliadaPreventiva['ds_endereco_empresa'] }}</label>
                                                                <br>
                                                                <label>Email: {{ $dadosEmpresaMelhorAvaliadaPreventiva['ds_email_empresa'] }}</label>
                                                                <br>
                                                                <label>Telefone: {{ $dadosEmpresaMelhorAvaliadaPreventiva['ds_telefone_empresa'] }}</label>
                                                                <br>
                                                            </p>
                                                            <p style="margin-bottom: 0">
                                                                <i class="fas fa-wrench text-blue"></i> Já efetuou <b>{{ $dadosEmpresaMelhorAvaliadaPreventiva['qtdManutencoes'] }}</b> manutenções
                                                                <br> 
                                                                @if( ($dadosEmpresaMelhorAvaliadaPreventiva['superiorMedia']) == false)
                                                                <i class="fas fa-star-half-alt text-yellow"></i> A empresa possui notas <b>Médias</b>
                                                                <br>
                                                                <i class="fas fa-lightbulb text-green"></i> Pode ser interessante a contratação de uma nova empresa para melhorar ainda mais o rendimento. 
                                                                @elseif( ($dadosEmpresaMelhorAvaliadaPreventiva['superiorMedia']) == true)
                                                                <i class="fas fa-star text-yellow"></i> A empresa possui notas <b>Ótimas</b>
                                                                <br>
                                                                <i class="fas fa-lightbulb text-green"></i> Contratar esta empresa é sempre uma boa ideia! 
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-sm-6 col-md-6">
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                                                  <b>Nenhuma empresa indicada!</b>
                                                </h4>
                                                <div class="media">
                                                    <div class="media-left">
                                                      <i class="fas fa-exclamation fa-7x text-red"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="clearfix">
                                                            <p>
                                                                <label>1 - A empresas que já prestaram serviços, não obtiveram uma avaliação média para serem indicadas.</label>
                                                                <br>
                                                                <label>2 - Nenhuma empresa prestou serviço para o tipo escolhido.</label>
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
                        <!-- FIM DOS DADOS DA COLAPSE -->

                        <!-- INICIO DOS DADOS DA COLAPSE CORRETIVA-->
                        <div class="panel box box-success">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                    <b>Corretiva</b>
                                  </a>
                                </h4>
                            </div>
                            <div id="collapse2" class="panel-collapse collapse">
                                <div class="box-body">
                                    @if($dadosEmpresaMelhorAvaliadaCorretiva['indicar'] == true)
                                    <div class="col-sm-12 col-md-12">
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                                                  <b>{{ $dadosEmpresaMelhorAvaliadaCorretiva['nm_empresa'] }}</b>
                                                </h4>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <i class="fas fa-check fa-7x text-green"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="clearfix">
                                                            <h4 style="margin-top: 0">Contato:</h4>
                                                            <p>
                                                                <label>Nome: {{ $dadosEmpresaMelhorAvaliadaCorretiva['nm_empresa'] }}</label>
                                                                <br>
                                                                <label>Endereço: {{ $dadosEmpresaMelhorAvaliadaCorretiva['ds_endereco_empresa'] }}</label>
                                                                <br>
                                                                <label>Email: {{ $dadosEmpresaMelhorAvaliadaCorretiva['ds_email_empresa'] }}</label>
                                                                <br>
                                                                <label>Telefone: {{ $dadosEmpresaMelhorAvaliadaCorretiva['ds_telefone_empresa'] }}</label>
                                                                <br>
                                                            </p>
                                                            <p style="margin-bottom: 0">
                                                                <i class="fas fa-wrench text-blue"></i> Já efetuou <b>{{ $dadosEmpresaMelhorAvaliadaCorretiva['qtdManutencoes'] }}</b> manutenções
                                                                <br> 
                                                                @if( ($dadosEmpresaMelhorAvaliadaCorretiva['superiorMedia']) == false)
                                                                  <i class="fas fa-star-half-alt text-yellow"></i> A empresa possui notas <b>Médias</b>
                                                                  <br>
                                                                  <i class="fas fa-lightbulb text-green"></i> Pode ser interessante a contratação de uma nova empresa para melhorar ainda mais o rendimento. 
                                                                @elseif( ($dadosEmpresaMelhorAvaliadaCorretiva['superiorMedia']) == true)
                                                                  <i class="fas fa-star text-yellow"></i> A empresa possui notas <b>Ótimas</b>
                                                                  <br>
                                                                  <i class="fas fa-lightbulb text-green"></i> Contratar esta empresa é sempre uma boa ideia! 
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-sm-6 col-md-6">
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                                                  <b>Nenhuma empresa indicada!</b>
                                                </h4>
                                                <div class="media">
                                                    <div class="media-left">
                                                      <i class="fas fa-exclamation fa-7x text-red"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="clearfix">
                                                            <p>
                                                                <label>1 - A empresas que já prestaram serviços, não obtiveram uma avaliação média para serem indicadas.</label>
                                                                <br>
                                                                <label>2 - Nenhuma empresa prestou serviço para o tipo escolhido.</label>
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
                        <!-- FIM DOS DADOS DA COLAPSE -->

                    </div>
                </div>
            </div>
        </div>
        <!-- FIM DA COLAPSE -->
    </div>
</div>

<!-- parte de equipamentos -->
<div class="box box-primary">
    <div class="box-body">
        <!-- INICIO COLAPSE -->
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                  <i class="fas fa-angle-right"></i></i><h3 class="box-title"> Apresentar melhor empresa prestadora por <b>tipo de equipamento</b>:</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-group" id="accordion2">
                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                        
                        <!-- INICIO DOS DADOS DA COLAPSE ELETROELETRONICO-->
                        <div class="panel box box-success">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                  <a data-toggle="collapse" data-parent="#accordion2" href="#collapse3" >
                                    <b>Eletroeletrônico</b>
                                  </a>
                                </h4>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse" >
                                <div class="box-body">
                                    @if($dadosEmpresaMelhorAvaliadaEletroeletronico['indicar'] == true)
                                    <div class="col-sm-12 col-md-12">
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                                                  <b>{{ $dadosEmpresaMelhorAvaliadaEletroeletronico['nm_empresa'] }}</b>
                                                </h4>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <i class="fas fa-check fa-7x text-green"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="clearfix">
                                                            <h4 style="margin-top: 0">Contato:</h4>
                                                            <p>
                                                                <label>Nome: {{ $dadosEmpresaMelhorAvaliadaEletroeletronico['nm_empresa'] }}</label>
                                                                <br>
                                                                <label>Endereço: {{ $dadosEmpresaMelhorAvaliadaEletroeletronico['ds_endereco_empresa'] }}</label>
                                                                <br>
                                                                <label>Email: {{ $dadosEmpresaMelhorAvaliadaEletroeletronico['ds_email_empresa'] }}</label>
                                                                <br>
                                                                <label>Telefone: {{ $dadosEmpresaMelhorAvaliadaEletroeletronico['ds_telefone_empresa'] }}</label>
                                                                <br>
                                                            </p>
                                                            <p style="margin-bottom: 0">
                                                                <i class="fas fa-wrench text-blue"></i> Já efetuou <b>{{ $dadosEmpresaMelhorAvaliadaEletroeletronico['qtdManutencoes'] }}</b> manutenções
                                                                <br> 
                                                                @if( ($dadosEmpresaMelhorAvaliadaEletroeletronico['superiorMedia']) == false)
                                                                  <i class="fas fa-star-half-alt text-yellow"></i> A empresa possui notas <b>Médias</b>
                                                                  <br>
                                                                  <i class="fas fa-lightbulb text-green"></i> Pode ser interessante a contratação de uma nova empresa para melhorar ainda mais o rendimento. 
                                                                @elseif( ($dadosEmpresaMelhorAvaliadaEletroeletronico['superiorMedia']) == true)
                                                                  <i class="fas fa-star text-yellow"></i> A empresa possui notas <b>Ótimas</b>
                                                                  <br>
                                                                  <i class="fas fa-lightbulb text-green"></i> Contratar esta empresa é sempre uma boa ideia! 
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-sm-6 col-md-6">
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                                                  <b>Nenhuma empresa indicada!</b>
                                                </h4>
                                                <div class="media">
                                                    <div class="media-left">
                                                      <i class="fas fa-exclamation fa-7x text-red"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="clearfix">
                                                            <p>
                                                                <label>1 - A empresas que já prestaram serviços, não obtiveram uma avaliação média para serem indicadas.</label>
                                                                <br>
                                                                <label>2 - Nenhuma empresa prestou serviço para o tipo escolhido.</label>
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
                        <!-- FIM DOS DADOS DA COLAPSE -->

                        <!-- INICIO DOS DADOS DA COLAPSE ELETRONICO -->
                        <div class="panel box box-success">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                  <a data-toggle="collapse" data-parent="#accordion2" href="#collapse4" >
                                    <b>Eletrônico</b>     
                                  </a>
                                </h4>
                            </div>
                            <div id="collapse4" class="panel-collapse collapse" >
                                <div class="box-body">
                                    @if($dadosEmpresaMelhorAvaliadaEletronico['indicar'] == true)
                                    <div class="col-sm-12 col-md-12">
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                                                  <b>{{ $dadosEmpresaMelhorAvaliadaEletronico['nm_empresa'] }}</b>
                                                </h4>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <i class="fas fa-check fa-7x text-green"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="clearfix">
                                                            <h4 style="margin-top: 0">Contato:</h4>
                                                            <p>
                                                                <label>Nome: {{ $dadosEmpresaMelhorAvaliadaEletronico['nm_empresa'] }}</label>
                                                                <br>
                                                                <label>Endereço: {{ $dadosEmpresaMelhorAvaliadaEletronico['ds_endereco_empresa'] }}</label>
                                                                <br>
                                                                <label>Email: {{ $dadosEmpresaMelhorAvaliadaEletronico['ds_email_empresa'] }}</label>
                                                                <br>
                                                                <label>Telefone: {{ $dadosEmpresaMelhorAvaliadaEletronico['ds_telefone_empresa'] }}</label>
                                                                <br>
                                                            </p>
                                                            <p style="margin-bottom: 0">
                                                                <i class="fas fa-wrench text-blue"></i> Já efetuou <b>{{ $dadosEmpresaMelhorAvaliadaEletronico['qtdManutencoes'] }}</b> manutenções
                                                                <br> 
                                                                @if( ($dadosEmpresaMelhorAvaliadaEletronico['superiorMedia']) == false)
                                                                  <i class="fas fa-star-half-alt text-yellow"></i> A empresa possui notas <b>Médias</b>
                                                                  <br>
                                                                  <i class="fas fa-lightbulb text-green"></i> Pode ser interessante a contratação de uma nova empresa para melhorar ainda mais o rendimento. 
                                                                @elseif( ($dadosEmpresaMelhorAvaliadaEletronico['superiorMedia']) == true)
                                                                  <i class="fas fa-star text-yellow"></i> A empresa possui notas <b>Ótimas</b>
                                                                  <br>
                                                                  <i class="fas fa-lightbulb text-green"></i> Contratar esta empresa é sempre uma boa ideia! 
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-sm-6 col-md-6">
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                                                  <b>Nenhuma empresa indicada!</b>
                                                </h4>
                                                <div class="media">
                                                    <div class="media-left">
                                                      <i class="fas fa-exclamation fa-7x text-red"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="clearfix">
                                                            <p>
                                                                <label>1 - A empresas que já prestaram serviços, não obtiveram uma avaliação média para serem indicadas.</label>
                                                                <br>
                                                                <label>2 - Nenhuma empresa prestou serviço para o tipo escolhido.</label>
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
                        <!-- FIM DOS DADOS DA COLAPSE -->

                        <!-- INICIO DOS DADOS DA COLAPSE ELETRICO -->
                        <div class="panel box box-success">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                  <a data-toggle="collapse" data-parent="#accordion2" href="#collapse5" >
                                    <b>Elétrico</b> 
                                  </a>
                                </h4>
                            </div>
                            <div id="collapse5" class="panel-collapse collapse" >
                                <div class="box-body">
                                    @if($dadosEmpresaMelhorAvaliadaEletrico['indicar'] == true)
                                    <div class="col-sm-12 col-md-12">
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                                                  <b>{{ $dadosEmpresaMelhorAvaliadaEletrico['nm_empresa'] }}</b>
                                                </h4>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <i class="fas fa-check fa-7x text-green"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="clearfix">
                                                            <h4 style="margin-top: 0">Contato:</h4>
                                                            <p>
                                                                <label>Nome: {{ $dadosEmpresaMelhorAvaliadaEletrico['nm_empresa'] }}</label>
                                                                <br>
                                                                <label>Endereço: {{ $dadosEmpresaMelhorAvaliadaEletrico['ds_endereco_empresa'] }}</label>
                                                                <br>
                                                                <label>Email: {{ $dadosEmpresaMelhorAvaliadaEletrico['ds_email_empresa'] }}</label>
                                                                <br>
                                                                <label>Telefone: {{ $dadosEmpresaMelhorAvaliadaEletrico['ds_telefone_empresa'] }}</label>
                                                                <br>
                                                            </p>
                                                            <p style="margin-bottom: 0">
                                                                <i class="fas fa-wrench text-blue"></i> Já efetuou <b>{{ $dadosEmpresaMelhorAvaliadaEletrico['qtdManutencoes'] }}</b> manutenções
                                                                <br> 
                                                                @if( ($dadosEmpresaMelhorAvaliadaEletrico['superiorMedia']) == false)
                                                                  <i class="fas fa-star-half-alt text-yellow"></i> A empresa possui notas <b>Médias</b>
                                                                  <br>
                                                                  <i class="fas fa-lightbulb text-green"></i> Pode ser interessante a contratação de uma nova empresa para melhorar ainda mais o rendimento. 
                                                                @elseif( ($dadosEmpresaMelhorAvaliadaEletrico['superiorMedia']) == true)
                                                                  <i class="fas fa-star text-yellow"></i> A empresa possui notas <b>Ótimas</b>
                                                                  <br>
                                                                  <i class="fas fa-lightbulb text-green"></i> Contratar esta empresa é sempre uma boa ideia! 
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-sm-6 col-md-6">
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                                                  <b>Nenhuma empresa indicada!</b>
                                                </h4>
                                                <div class="media">
                                                    <div class="media-left">
                                                      <i class="fas fa-exclamation fa-7x text-red"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="clearfix">
                                                            <p>
                                                                <label>1 - A empresas que já prestaram serviços, não obtiveram uma avaliação média para serem indicadas.</label>
                                                                <br>
                                                                <label>2 - Nenhuma empresa prestou serviço para o tipo escolhido.</label>
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
                        <!-- FIM DOS DADOS DA COLAPSE -->

                        <!-- INICIO DOS DADOS DA COLAPSE ELETRODOMESTICO -->
                        <div class="panel box box-success">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                  <a data-toggle="collapse" data-parent="#accordion2" href="#collapse6" >
                                    <b>Eletrodoméstico</b>
                                  </a>
                                </h4>
                            </div>
                            <div id="collapse6" class="panel-collapse collapse" >
                                <div class="box-body">
                                    @if($dadosEmpresaMelhorAvaliadaEletrodomestico['indicar'] == true)
                                    <div class="col-sm-12 col-md-12">
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                                                  <b>{{ $dadosEmpresaMelhorAvaliadaEletrodomestico['nm_empresa'] }}</b>
                                                </h4>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <i class="fas fa-check fa-7x text-green"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="clearfix">
                                                            <h4 style="margin-top: 0">Contato:</h4>
                                                            <p>
                                                                <label>Nome: {{ $dadosEmpresaMelhorAvaliadaEletrodomestico['nm_empresa'] }}</label>
                                                                <br>
                                                                <label>Endereço: {{ $dadosEmpresaMelhorAvaliadaEletrodomestico['ds_endereco_empresa'] }}</label>
                                                                <br>
                                                                <label>Email: {{ $dadosEmpresaMelhorAvaliadaEletrodomestico['ds_email_empresa'] }}</label>
                                                                <br>
                                                                <label>Telefone: {{ $dadosEmpresaMelhorAvaliadaEletrodomestico['ds_telefone_empresa'] }}</label>
                                                                <br>
                                                            </p>
                                                            <p style="margin-bottom: 0">
                                                                <i class="fas fa-wrench text-blue"></i> Já efetuou <b>{{ $dadosEmpresaMelhorAvaliadaEletrodomestico['qtdManutencoes'] }}</b> manutenções
                                                                <br> 
                                                                @if( ($dadosEmpresaMelhorAvaliadaEletrodomestico['superiorMedia']) == false)
                                                                  <i class="fas fa-star-half-alt text-yellow"></i> A empresa possui notas <b>Médias</b>
                                                                  <br>
                                                                  <i class="fas fa-lightbulb text-green"></i> Pode ser interessante a contratação de uma nova empresa para melhorar ainda mais o rendimento. 
                                                                @elseif( ($dadosEmpresaMelhorAvaliadaEletrodomestico['superiorMedia']) == true)
                                                                  <i class="fas fa-star text-yellow"></i> A empresa possui notas <b>Ótimas</b>
                                                                  <br>
                                                                  <i class="fas fa-lightbulb text-green"></i> Contratar esta empresa é sempre uma boa ideia! 
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-sm-6 col-md-6">
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                                                  <b>Nenhuma empresa indicada!</b>
                                                </h4>
                                                <div class="media">
                                                    <div class="media-left">
                                                      <i class="fas fa-exclamation fa-7x text-red"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="clearfix">
                                                            <p>
                                                                <label>1 - A empresas que já prestaram serviços, não obtiveram uma avaliação média para serem indicadas.</label>
                                                                <br>
                                                                <label>2 - Nenhuma empresa prestou serviço para o tipo escolhido.</label>
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
                        <!-- FIM DOS DADOS DA COLAPSE -->

                    </div>
                </div>
            </div>
        </div>
        <!-- FIM DA COLAPSE -->
    </div>
</div>


@stop