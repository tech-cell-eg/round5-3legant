@extends('adminlte::page')

@section('title', 'orders')

@section('content_header')
    <h1>admins</h1>
@stop

@section('content')
@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
<a style="margin-bottom:10px" class="btn btn-success" href={{ route('users.createUserView') }}>Create new admin</a>
{{-- @if(Auth::check())
    Welcome, {{ Auth::user()->name }}
@else
    You are not logged in.
@endif --}}
{{-- {{ $admins }} --}}
    <table class="table">
        <thead>
            <tr>
                <th>admin username</th>
                <th>admin email</th>
                <th>creation account date</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
                <tr id="order-{{ $admin->id }}">
                    <td>{{ $admin->username }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->created_at }}</td>
                    <td style="display:flex;">
                        <a href="{{ route('users.view', $admin->id) }}" class="btn btn-primary">View</a>                        
                        <a href="{{ route('users.edit', $admin->id) }}" class="btn btn-primary">Edit</a>                        
                        <form method="post" action={{ route('users.delete', $admin->id) }}  >
                            @csrf
                            @method('delete')
                            <button type="submit" class="delete_button btn btn-danger" >Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('js')
<script>
    $(function () {
        $('.delete_button').on('click', function (e) {
            if(!confirm("Are you sure you want to delete admin?")){
            e.preventDefault();
            }
        });
    });
</script>

@endsection
