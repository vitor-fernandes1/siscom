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
                        <i style="padding: 7px 30px; margin-top: 0 ;" class="fas fa-laptop fa-5x"></i>
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
                    <a href="/equipamento" class="ad-click-event">
                        <i style="padding: 7px 30px; margin-top: 0 ;" class="fas fa-building fa-5x"></i>
                    </a>
                </div>
                <div class="media-right">
                    <div class="clearfix">
                        <h3 style=" font-size: 27px; text-align: left; padding: 7px 0px; margin-top: 0 ;">Empresa</h3>
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
                    <a href="/equipamento" class="ad-click-event">
                        <i style="padding: 7px 30px; margin-top: 0 ;" class="fas fa-cogs fa-5x"></i>
                    </a>
                </div>
                <div class="media-right">
                    <div class="clearfix">
                        <h3 style=" font-size: 27px; text-align: left; padding: 7px 0px; margin-top: 0 ;">Manutenção</h3>
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
                    <a href="/equipamento" class="ad-click-event">
                        <i style="padding: 7px 30px; margin-top: 0 ;" class="fas fa-exclamation-circle fa-5x"></i>
                    </a>
                </div>
                <div class="media-right">
                    <div class="clearfix">
                        <h3 style=" font-size: 27px; text-align: left; padding: 7px 0px; margin-top: 0 ;">Avisos</h3>
                        <p style=" font-size: 16px; text-align: left; padding: 2px 0px; margin-top: 0 ;" class="lead">Acessar funcionalidade de equipamento</p>
                       
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop