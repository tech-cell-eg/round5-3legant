@extends('adminlte::page')

@section('title', 'Product')

@section('content_header')
    <h1>Edit Product</h1>
@stop

@section('content')
    @include('admin.partials.alerts')

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('products.update', $product->id) }}"
                        class="row g-3">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6">
                            <x-adminlte-input name="name" value="{{ $product->name }}" required label="Name"
                                placeholder="Product name" class="form-control" disable-feedback />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="category">Category</label>
                            <x-adminlte-select2 required name="category_id" id="category" class="form-control">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-gradient-info"><i class="fas fa-car-side"></i></div>
                                </x-slot>
                                <x-adminlte-options :options="$categories" :selected="$product->category_id" empty-option="None" />
                            </x-adminlte-select2>
                        </div>

                        <div class="col-12">
                            <x-adminlte-textarea required name="description" label="Description" rows=5
                                placeholder="Enter description">
                                {{ $product->description }}
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-dark"><i class="fas fa-lg fa-file-alt"></i></div>
                                </x-slot>
                            </x-adminlte-textarea>
                        </div>

                        <div class="col-12">
                            <x-adminlte-input value="{{ $product->base_price }}" required name="base_price"
                                label="Base price" type="number" min="1" step="0.01">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-dark"><i class="fas fa-hashtag"></i></div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        <div class="col-12">
                            <h4>Product Variations</h4>
                            <div id="variations-wrapper"></div>
                        </div>
                        @foreach ($variations as $var)
                            <div class="variation-item border rounded p-3 mb-3">
                                <div class="row g-3">
                                    <div class="col-md-2">
                                        <label>Color</label>
                                        <input type="text" value="{{ $var->color }}"
                                            name="variations[{{ $var->id }}][color]" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Size</label>
                                        <input type="text" value="{{ $var->size }}"
                                            name="variations[{{ $var->id }}][size]" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Measurements</label>
                                        <input type="text" value="{{ $var->measurements }}"
                                            name="variations[{{ $var->id }}][measurements]" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Quantity</label>
                                        <input type="number" value="{{ $var->quantity }}"
                                            name="variations[{{ $var->id }}][quantity]" class="form-control"
                                            min="1">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Price</label>
                                        <input type="number" value="{{ $var->price }}"
                                            name="variations[{{ $var->id }}][price]" class="form-control"
                                            step="0.01" min="0">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Existing Images</label>
                                        <div class="d-flex flex-wrap">
                                            @foreach ($var->images as $img)
                                                <div class="m-1 position-relative">
                                                    <img src="{{ asset('storage/' . $img->image) }}" class="img-thumbnail"
                                                        style="width:100px;height:100px;object-fit:cover;">

                                                    <button type="button" data-id="{{ $img->id }}"
                                                        class="btn btn-danger btn-sm mt-2 delete-image-btn"><i
                                                            class="fas fa-times"></i></button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Add More Images</label>
                                        <input type="file" name="variation_images[{{ $var->id }}][]" multiple
                                            class="form-control" accept="image/*">
                                    </div>
                                </div>

                                <button type="button" data-id="{{ $var->id }}"
                                    class="btn btn-danger btn-sm mt-2 delete-variation-btn">Remove</button>
                            </div>
                        @endforeach

                        <div class="col-12 text-center">
                            <button type="button" id="add-variation" class="btn btn-primary px-5">Add Product
                                Variation</button>
                        </div>

                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-success px-5">Save Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for delete --}}
    <x-adminlte-modal id="deleteModal" title="Delete Variation" theme="danger" icon="fas fa-trash">
        <p>Are you sure you want to delete<strong>this variation</strong>?</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <x-adminlte-button type="submit" label="Yes, Delete" theme="danger" class="mr-2" />
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </form>
    </x-adminlte-modal>

    <x-adminlte-modal id="deleteImageModal" title="Delete Image" theme="danger" icon="fas fa-trash">
        <p>Are you sure you want to delete <strong>this variation</strong>?</p>
        <form id="deleteImageForm" method="POST">
            @csrf
            @method('DELETE')
            <x-adminlte-button type="submit" label="Yes, Delete" theme="danger" class="mr-2" />
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </form>
    </x-adminlte-modal>

    @push('js')
        <script>
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-variation-btn')) {
                    let id = e.target.closest('.delete-variation-btn').dataset.id;
                    document.getElementById('deleteForm').action = `/admin/product/variation/${id}`;
                    $('#deleteModal').modal('show');
                }
            });
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-image-btn')) {
                    let id = e.target.closest('.delete-image-btn').dataset.id;
                    document.getElementById('deleteImageForm').action = `/admin/product/variation/images/${id}`;
                    $('#deleteImageModal').modal('show');
                }
            });

            let variationIndex = 0;
            document.getElementById('add-variation').addEventListener('click', function() {
                variationIndex++;
                let html = `
            <div class="variation-item border rounded p-3 mb-3">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label>Color</label>
                        <input type="text" name="variations[new_${variationIndex}][color]" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>Size</label>
                        <input type="text" name="variations[new_${variationIndex}][size]" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Measurements</label>
                        <input type="text" name="variations[new_${variationIndex}][measurements]" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>Quantity</label>
                        <input type="number" name="variations[new_${variationIndex}][quantity]" class="form-control" min="1">
                    </div>
                    <div class="col-md-3">
                        <label>Price</label>
                        <input type="number" name="variations[new_${variationIndex}][price]" class="form-control" step="0.01" min="0">
                    </div>
                    <div class="col-md-12">
                        <label>Product Images</label>
                        <input type="file" name="variations[new_${variationIndex}][product_images][]" multiple class="form-control" accept="image/*">
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm mt-2 remove-variation">Remove</button>
            </div>`;
                document.getElementById('variations-wrapper').insertAdjacentHTML('beforeend', html);
            });

            // Remove dynamically added variation blocks
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-variation')) {
                    e.target.closest('.variation-item').remove();
                }
            });
        </script>
    @endpush
@stop
