@extends('adminlte::page')

@section('title', 'Saldo')

@section('content_header')
    <h1>Saldo</h1>

    <ol class="breadcrumb">
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Saldo</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <a class="btn btn-primary" href="{{ route('balance.deposito') }}">
                <i class="fas fa-cart-plus" aria-hidden="true"></i>
                Recarregar
            </a>
            @if($amount > 0)
            <a class="btn btn-danger" href="{{ route('balance.sacar') }}">
                <i class="fas fa-cart-arrow-down" aria-hidden="true"></i> Sacar</a>
            @endif

            @if($amount > 0)
                <a class="btn btn-info" href="{{ route('balance.transfer') }}">
                    <i class="fas fa-exchange-alt"></i> Transferir</a>
            @endif

        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>R$ {{ number_format($amount, 2 ,',' , '') }}</h3>

                </div>
                <div class="icon">
                    <i class="ion ion-cash"></i>
                </div>
                <a href="#" class="small-box-footer">Histórico <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@stop