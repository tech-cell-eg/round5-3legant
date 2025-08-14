@extends('adminlte::page')

@section('title', 'Product')

@section('content_header')
    <h1>Products</h1>
@stop

@section('content')
    {{-- Alerts --}}
    @include('admin.partials.alerts')

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
    <x-adminlte-datatable id="productsTable" :heads="$heads" striped hoverable bordered>
        @foreach ($products as $product)
            <tr>
                <td class="text-center align-middle">{{ $product->id }}</td>
                <td class="text-center align-middle">{{ $product->name }}</td>
                <td class="text-center align-middle">{{ Str::limit($product->description, 50, '...') }}</td>
                <td class="text-center align-middle">{{ $product->category->name ?? '-' }}</td>
                <td class="text-center align-middle">{{ $product->base_price }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}"><button
                            class="btn btn-xs btn-default text-primary mx-1 shadow">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button></a>
                    <button class="btn btn-xs btn-default text-danger mx-1 shadow" data-toggle="modal"
                        data-target="#deleteModal{{ $product->id }}">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </button>
                </td>
            </tr>
            <x-adminlte-modal id="deleteModal{{ $product->id }}" title="Delete Product" theme="danger" icon="fas fa-trash">
                <p>Are you sure you want to delete <strong>{{ $product->name }}</strong>?</p>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-adminlte-button type="submit" label="Yes, Delete" theme="danger" class="mr-2" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </x-adminlte-modal>
        @endforeach
    </x-adminlte-datatable>

@stop
