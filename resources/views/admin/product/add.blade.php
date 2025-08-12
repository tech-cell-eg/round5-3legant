@extends('adminlte::page')

@section('title', 'Product')

@section('content_header')
    <h1 class="text-center">Add Product</h1>
@stop

@section('content')
    {{-- Alerts --}}
    @if (session('success'))
        <div class="col-sm-6 mx-auto">
            <x-adminlte-alert theme="success" title="Success" id="autoCloseAlert" class="p-2" dismissable>
                {{ session('success') }}
            </x-adminlte-alert>
        </div>
    @endif
    @if (session('error'))
        <div class="col-sm-6 mx-auto">
            <x-adminlte-alert theme="danger" title="Error" dismissable>
                {{ session('error') }}
            </x-adminlte-alert>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <form method="POST" action="{{ route('products.store') }}" class="row g-3">
                        @csrf
                        {{-- Main product fields --}}
                        <div class="col-md-6">
                            <x-adminlte-input name="name" label="Name" placeholder="Product name" class="form-control"
                                disable-feedback />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category">Category</label>
                            <x-adminlte-select2 name="category_id" id="category" label-class="text-lightblue"
                                class="form-control">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-gradient-info">
                                        <i class="fas fa-car-side"></i>
                                    </div>
                                </x-slot>
                                <x-adminlte-options :options="$categories" empty-option />
                            </x-adminlte-select2>
                        </div>
                        <div class="col-12">
                            <x-adminlte-textarea name="description" label="Description" rows=5 igroup-size="sm"
                                placeholder="Insert description...">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-dark">
                                        <i class="fas fa-lg fa-file-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-textarea>
                        </div>
                        <div class="col-12">
                            <x-adminlte-input name="base_price" label="Base price" placeholder="..." type="number"
                                igroup-size="sm" min=1 step="0.01">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-dark">
                                        <i class="fas fa-hashtag"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        <div class="col-12">
                            <h4>Product Variations</h4>
                            <div id="variations-wrapper"></div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="button" id="add-variation" class="btn btn-primary px-5">
                                Add Product Variation
                            </button>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-success px-5">Save Product</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            let variationIndex = 0;

            document.getElementById('add-variation').addEventListener('click', function() {
                variationIndex++;

                let variationHtml = `
            <div class="variation-item border rounded p-3 mb-3">
                <h6>Variation #${variationIndex}</h6>
                <div class="row g-3">
                    <div class="col-md-2">
                        <x-adminlte-input name="variations[${variationIndex}][color]" label="Color" placeholder="Color" />
                    </div>
                    <div class="col-md-2">
                        <x-adminlte-input name="variations[${variationIndex}][size]" label="Size" placeholder="Size" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-input name="variations[${variationIndex}][measurements]" label="Measurements" placeholder="e.g. 10x20 cm" />
                    </div>
                    <div class="col-md-2">
                        <x-adminlte-input name="variations[${variationIndex}][quantity]" label="Quantity" type="number" min="1" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-input name="variations[${variationIndex}][price]" label="Price" type="number" step="0.01" min="0" />
                    </div>
                    <div class="col-md-12">
                        <label>Variation Images</label>
                        <input type="file" name="variations[${variationIndex}][images][]" multiple class="form-control" accept="image/*">
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm mt-2 remove-variation">Remove</button>
            </div>
        `;

                document.getElementById('variations-wrapper').insertAdjacentHTML('beforeend', variationHtml);
            });

            // Remove variation
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-variation')) {
                    e.target.closest('.variation-item').remove();
                }
            });
        </script>
    @endpush


@stop
