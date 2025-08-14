@extends('adminlte::page')

@section('title', 'user data')

@section('content_header')
    <h1>{{ $user->username }} Data</h1>
@stop
@section('content')
@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>first name</th>
            <th>last name</th>
            <th>user name</th>
            <th>email</th>
            <th>account created at</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td scope="row">{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
        </tr>
    </tbody>
</table>
@stop

{{-- @section('js')
<script>
    $(function () {
        $('.order-status').on('change', function () {
            let orderId = $(this).data('id');
            let newStatus = $(this).val();

            $.ajax({
                url: "{{ route('orders.updateStatus') }}", 
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: orderId,
                    status: newStatus
                },
                success: function (response) {
                    console.log(response);
                    alert('Order status updated successfully!');
                },
                error: function (xhr) {
                    alert('Failed to update status');
                }
            });
        });
    });
</script>

@endsection --}}
