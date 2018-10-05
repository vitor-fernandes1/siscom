@extends('adminlte::page')

@section('title', 'Siscom')

@section('content_header')
    <h1>Central de Apoio</h1>
@stop

@section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<div class="col-sm-15 col-md-6">
    <div class="box box-primary">
        <div class="box-body">
            <br>
            <div class="media">
                <div class="media-left">
                    <a href="/estatistica" class="ad-click-event">
                        <i style="padding: 7px 30px; margin-top: 0 ;" class="fas fa-calculator fa-5x"></i>
                    </a>
                </div>
                <div class="media-right">
                    <div class="clearfix">
                        <h3 style=" font-size: 27px; text-align: left; padding: 7px 0px; margin-top: 0 ;">Estatísticas</h3>
                        <p style=" font-size: 16px; text-align: left; padding: 2px 0px; margin-top: 0 ;" class="lead">Reuni informações estatísticas do equipamento</p>
                       
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-15 col-md-6">
    <div class="box box-primary">
        <div class="box-body">
            <br>
            <div class="media">
                <div class="media-left">
                    <a href="/grafico" class="ad-click-event">
                        <i style="padding: 7px 30px; margin-top: 0 ;" class="fas fa-chart-line fa-5x"></i>
                    </a>
                </div>
                <div class="media-right">
                    <div class="clearfix">
                        <h3 style=" font-size: 27px; text-align: left; padding: 7px 0px; margin-top: 0 ;">Gráfico</h3>
                        <p style=" font-size: 16px; text-align: left; padding: 2px 0px; margin-top: 0 ;" class="lead">Gera graficos de projeção de custos do equipamento</p>
                       
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop