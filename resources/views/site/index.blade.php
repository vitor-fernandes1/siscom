@extends('adminlte::page')

@section('title', 'Siscom')

@section('content_header')
    <h1>Painel</h1>
@stop

@section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<div class="col-sm-15 col-md-6">
    <div class="box box-primary">
        <div class="box-body">
            <br>
            <div class="media">
                <div class="media-left">
                    <a href="/equipamento" class="ad-click-event">
                        <i style="padding: 7px 30px; margin-top: 0 ;" class="fas fa-laptop fa-5x text-primary"></i>
                    </a>
                </div>
                <div class="media-right">
                    <div class="clearfix">
                        <h3 style=" font-size: 27px; text-align: left; padding: 7px 0px; margin-top: 0 ;">Equipamento</h3>
                        <p style=" font-size: 16px; text-align: left; padding: 2px 0px; margin-top: 0 ;" class="lead">Acessar funcionalidade de equipamento</p>
                       
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
                    <a href="/central" class="ad-click-event">
                        <i style="padding: 7px 30px; margin-top: 0 ;" class="fas fa-hands-helping fa-5x text-primary"></i>
                    </a>
                </div>
                <div class="media-right">
                    <div class="clearfix">
                        <h3 style=" font-size: 27px; text-align: left; padding: 7px 0px; margin-top: 0 ;">Central de apoio</h3>
                        <p style=" font-size: 16px; text-align: left; padding: 2px 0px; margin-top: 0 ;" class="lead">Acessar funcionalidade de central de apoio</p>
                       
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
                    <a href="/gerenciamento" class="ad-click-event">
                        <i style="padding: 7px 30px; margin-top: 0 ;" class="fas fa-heartbeat fa-5x text-primary"></i>
                    </a>
                </div>
                <div class="media-right">
                    <div class="clearfix">
                        <h3 style=" font-size: 27px; text-align: left; padding: 7px 0px; margin-top: 0 ;">Geren. Vida útil</h3>
                        <p style=" font-size: 16px; text-align: left; padding: 2px 0px; margin-top: 0 ;" class="lead">Acessar funcionalidade de geren. vida útil</p>
                       
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
                    <a href="/avisos" class="ad-click-event">
                        <i style="padding: 7px 30px; margin-top: 0 ;" class="fas fa-exclamation-circle fa-5x text-primary"></i>
                    </a>
                </div>
                <div class="media-right">
                    <div class="clearfix">
                        <h3 style=" font-size: 27px; text-align: left; padding: 7px 0px; margin-top: 0 ;">Avisos</h3>
                        <p style=" font-size: 16px; text-align: left; padding: 2px 0px; margin-top: 0 ;" class="lead">Acessar funcionalidade de avisos</p>
                       
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop