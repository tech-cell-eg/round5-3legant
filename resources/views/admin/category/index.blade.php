    @extends('adminlte::page')

    @section('title', 'Category')

    @section('content_header')
        <h1>Categories</h1>
    @stop

    @section('content')
        {{-- Alerts --}}
        @include('admin.partials.alerts')
        <x-adminlte-button label="Add Category" data-toggle="modal" data-target="#createModal" class="mb-3" theme="primary"
            icon="fas fa-plus" />
        <x-adminlte-modal id="createModal" title="Add New Category">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <x-adminlte-input name="name" label="Category Name" placeholder="Enter category name" required />
                <x-adminlte-select name="parent_id" label="Parent Category">
                    <option value="">None</option>
                    @foreach ($categories as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </x-adminlte-select>

                <x-adminlte-button type="submit" label="Create" theme="success" class="mt-3" />
            </form>
        </x-adminlte-modal>
        @php
            $heads = ['ID', 'Name', 'Parent', ['label' => 'Actions', 'no-export' => true, 'width' => 10]];
        @endphp
        <x-adminlte-datatable id="categoriesTable" :heads="$heads" striped hoverable bordered>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->parent?->name ?? '—' }}</td>
                    <td>
                        <button class="btn btn-xs btn-default text-primary mx-1 shadow" data-toggle="modal"
                            data-target="#updateModal{{ $category->id }}">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>
                        <button class="btn btn-xs btn-default text-danger mx-1 shadow" data-toggle="modal"
                            data-target="#deleteModal{{ $category->id }}">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <x-adminlte-modal id="updateModal{{ $category->id }}" title="Update Category">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-adminlte-input name="name" label="Category Name" value="{{ $category->name }}" required />
                        <x-adminlte-select name="parent_id" label="Parent Category">
                            <option value=""></option>
                            @foreach ($categories->where('id', '!=', $category->id) as $parent)
                                <option value="{{ $parent->id }}" @selected($category->parent_id == $parent->id)>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-button type="submit" label="Save" theme="success" class="mt-3" />
                    </form>
                </x-adminlte-modal>
                <x-adminlte-modal id="deleteModal{{ $category->id }}" title="Delete Category" theme="danger"
                    icon="fas fa-trash">
                    <p>Are you sure you want to delete <strong>{{ $category->name }}</strong>?</p>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-adminlte-button type="submit" label="Yes, Delete" theme="danger" class="mr-2" />
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </form>
                </x-adminlte-modal>
            @endforeach
        </x-adminlte-datatable>
    @stop
