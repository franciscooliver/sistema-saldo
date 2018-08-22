@extends('adminlte::page')

@section('title', 'transferir saldo')

@section('content_header')
    <h1>Confirmação de transferência</h1>

    <ol class="breadcrumb">
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Saldo</a></li>
        <li><a href="#">Transferir</a></li>
        <li><a href="#">Confirmação</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>Confirmar transferência saldo</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')

            <p style="font-size: 1.5rem;"><strong>Destinatário:</strong> {{ $user_recuperado->name }}</p>
            <p style="font-size: 1.5rem;"><strong>Seu saldo atual:</strong> {{ number_format($balance->amount, 2,',', '')  }}</p>
            <form method="POST" action="{{ route('transfer.store') }}">
                {{ csrf_field() }}
                <input type="hidden" name="sender_id" value="{{ $user_recuperado->id }}">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Valor:" name="value">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Transferir</button>
                </div>
            </form>
        </div>
    </div>

@stop