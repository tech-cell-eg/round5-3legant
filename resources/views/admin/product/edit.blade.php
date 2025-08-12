@extends('adminlte::page')

@section('title', 'Product')

@section('content_header')
    <h1>Edit Product</h1>
@stop
@section('content')
    {{-- Alerts --}}
    @if (session('success'))
        <div class="col-sm">
            <x-adminlte-alert theme="success" title="Success" id="autoCloseAlert" class="p-2" dismissable>
                {{ session('success') }}
            </x-adminlte-alert>
        </div>
    @endif
    @if (session('error'))
        <x-adminlte-alert theme="danger" title="Error" dismissable>
            {{ session('error') }}
        </x-adminlte-alert>
    @endif
@stop
