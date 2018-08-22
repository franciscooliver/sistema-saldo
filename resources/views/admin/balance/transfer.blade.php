@extends('adminlte::page')

@section('title', 'transferir saldo')

@section('content_header')
    <h1>Fazer transferência</h1>

    <ol class="breadcrumb">
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Saldo</a></li>
        <li><a href="#">Transferir</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>Fazer transferência (Digite o email do utilizador)</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
            <form method="POST" action="{{ route('confirm.transfer') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Email do destinatário" name="sender">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Próxima etapa</button>
                </div>
            </form>
        </div>
    </div>

@stop