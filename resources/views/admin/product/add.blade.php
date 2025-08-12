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
                    <form method="POST" enctype="multipart/form-data" action="{{ route('products.store') }}"
                        class="row g-3">
                        @csrf
                        {{-- Main product fields --}}
                        <div class="col-md-6">
                            <x-adminlte-input name="name" required label="Name" placeholder="Product name"
                                class="form-control" disable-feedback />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category">Category</label>
                            <x-adminlte-select2 required name="category_id" id="category" label-class="text-lightblue"
                                class="form-control">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-gradient-info">
                                        <i class="fas fa-car-side"></i>
                                    </div>
                                </x-slot>
                                <x-adminlte-options :options="$categories" empty-option="None" />
                            </x-adminlte-select2>
                        </div>
                        <div class="col-12">
                            <x-adminlte-textarea required name="description" label="Description" rows=5 igroup-size="sm"
                                placeholder="Enter description">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-dark">
                                        <i class="fas fa-lg fa-file-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-textarea>
                        </div>
                        <div class="col-12">
                            <x-adminlte-input required name="base_price" label="Base price" placeholder="Enter price"
                                type="number" igroup-size="sm" min=1 step="0.01">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-dark">
                                        <i class="fas fa-hashtag"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        <div class="col-md-12">
                            <label>Product Images</label>
                            <input type="file" name="product_images[]" multiple class="form-control" accept="image/*">
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
                            <button type="submit" name="action" value="save" class="btn btn-success px-5">
                                Save Product
                            </button>
                            <button type="submit" name="action" value="save_add" class="btn btn-primary px-5">
                                Save & Add Another
                            </button>
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
                                <label>Color</label>
                                <input type="text" name="variations[${variationIndex}][color]" class="form-control" placeholder="Color">
                            </div>
                            <div class="col-md-2">
                                <label>Size</label>
                                <input type="text" name="variations[${variationIndex}][size]" class="form-control" placeholder="Size">
                            </div>
                            <div class="col-md-3">
                                <label>Measurements</label>
                                <input type="text" name="variations[${variationIndex}][measurements]" class="form-control" placeholder="e.g. 10x20 cm">
                            </div>
                            <div class="col-md-2">
                                <label>Quantity</label>
                                <input type="number" name="variations[${variationIndex}][quantity]" class="form-control" min="1">
                            </div>
                            <div class="col-md-3">
                                <label>Price</label>
                                <input type="number" name="variations[${variationIndex}][price]" class="form-control" step="0.01" min="0">
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
