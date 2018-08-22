@extends('adminlte::page')

@section('title', 'Sacar')

@section('content_header')
    <h1>Fazer retirada</h1>

    <ol class="breadcrumb">
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Saldo</a></li>
        <li><a href="#">Sacar</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>Fazer retirada</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
            <form method="POST" action="{{ route('saque.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Valor da retirada" name="value">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Sacar</button>
                </div>
            </form>
        </div>
    </div>

@stop