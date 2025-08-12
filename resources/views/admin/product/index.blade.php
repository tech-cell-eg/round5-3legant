@extends('adminlte::page')

@section('title', 'Product')

@section('content_header')
    <h1>Products</h1>
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
    <a href="{{ route('products.create') }}"> <x-adminlte-button label="Add Product" class="mb-3" theme="primary"
            icon="fas fa-plus" /></a>

    @php
        $heads = [
            'ID',
            'Name',
            'Description',
            'Category',

            'Price',
            ['label' => 'Actions', 'no-export' => true, 'width' => 10],
        ];
        $varitaion = [];
    @endphp
    <x-adminlte-datatable id="categoriesTable" :heads="$heads" striped hoverable bordered>
        @foreach ($products as $product)
            <tr>
                <td class="text-center align-middle">{{ $product->id }}</td>
                <td class="text-center align-middle">{{ $product->name }}</td>
                <td class="text-center align-middle">{{ Str::limit($product->description, 50, '...') }}</td>
                <td class="text-center align-middle">{{ $product->category->name ?? '-' }}</td>
                <td class="text-center align-middle">{{ $product->base_price }}</td>
                <td>
                    <button class="btn btn-xs btn-default text-primary mx-1 shadow" data-toggle="modal"
                        data-target="#updateModal{{ $product->id }}">
                        <i class="fa fa-lg fa-fw fa-pen"></i>
                    </button>
                    <button class="btn btn-xs btn-default text-danger mx-1 shadow" data-toggle="modal"
                        data-target="#deleteModal">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>

@stop
